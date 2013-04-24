$(function(){
	$("#new-course").typeahead({ source: function(query, callback){
		$.getJSON(root_url+"Courses/byname/"+query, function(courses){
			callback(courses.map(function(c){ return c.name; }));
		});
	} });
	
	$("#new-nominee").typeahead({ source: function(query, callback){
		if(query.indexOf("|") >= 0) return;
		$.getJSON(root_url+"Courses/byteacher/"+query, function(courses){
			callback(courses);
		});
	} });
	
	// Add courses to selection
	function addCourses(courses){
		$table = $("table#courses-visible tbody");
		for(n in courses){
			if($table.find(".course-"+courses[n].id).size() == 0){
				var row = $("<tr><td><a class='delete' href='#'><i class='icon-trash'></i></td><td></td><td></td></a></tr>");
				row.addClass("course-"+courses[n].id).data("course", courses[n]).find("td")
				.first().append("<input type='hidden' class='course-id' name='course[]' value='"+courses[n].id+"' />")
				.next().text(courses[n].code)
				.next().text(courses[n].name)
				$table.append(row);
			}
		}
		update();
	}
	
	function resetCourses(){
		// Remove from table
		$table = $("table#courses-visible tbody");
		$table.find("tr").remove();
		
		// Remove from body class
		$("body").removeClass(($("body").attr("class") || "").split(" ").filter(
			function(el){ return el.indexOf("course-") == 0; 
		}).join(" "));
		
		update();
	}
	
	function update(save){
		if(typeof save == 'undefined') save = true;
		
		// Collect course ids
		var ids = $("table#courses-visible tr").map(function(){
			var id = $(this).find(".course-id").val();
			return typeof id == "undefined" ? null : parseInt(id);
		});
		ids = Array.prototype.slice.call(ids);
		
		updateTutors(ids);
		updateBar();
		
		// Save
		if(save)
			$.post(root_url+"Student/courses", $("#form-selected-courses").serialize());
		if(save)
			dirty(true);
		
		// Dependent on amount of courses
		$(".course-count").text(ids.length == 0 ? "" : " ("+ids.length+")");
		$(".if-empty").toggle(ids.length == 0);
	}
	update(false);
	
	function updateTutors(ids){
		// Hide and show teachers
		if(ids.length == 0) {
			$(".visible-tutors .tutor").hide();
		} else {
			$(".visible-tutors .tutor").filter(".course-"+ids.join(",.course-")).show();
			$(".visible-tutors .tutor").filter(":not(.course-"+ids.join(",.course-")+")").hide();
		}
	}
	
	function updateBar(){
		var total = 0, done = 0;
		$(".tutor:visible").each(function(){
			total++;
			
			var grade = $(this).find(".grade:not(.placeholdersjs)").val();
			if(grade && parseFloat(grade) >= 8 && $(this).find("textarea:not(.placeholdersjs)").val().length > 5)
				done++;
			else if(grade && parseFloat(grade) < 8)
				done++;
		});
		
		$(".progress .bar").css("width", ~~(done/total*100)+"%");
	}
	
	// Remove row if deleted
	$("table#courses-visible").on("click", ".delete", function(){
		$(this).parents("tr").hide(function(){ 
			$(this).remove();
			update();
		});
	});
	
	var isdirty = false;
	function dirty(s){
		isdirty = s;
		if(isdirty)
			$("form#form-votes input[type=submit]").removeAttr("disabled");
		else
			$("form#form-votes input[type=submit]").attr("disabled", 1);
	}
	dirty(false);
	
	// Handle votes
	function saveVotes(event){
		$.post(root_url+"Student/votes", $("form#form-votes").serialize(), function(){
			dirty(false);
		});
		
		// Prevent normal submit
		event.preventDefault();
		return false;
	}
	$("form#form-votes").on("submit", saveVotes);
	
	// Handle searches
	$("form#form-selected-courses").on("submit", function(event){
		var selectors = { 
			'.course-finder-program': "byprogram",
			'.course-finder-name': "byname", 
			'.course-finder-teacher': "byteacher"
		};
		
		for(sel in selectors){
			var val = $(sel).find("input, select").val();
			if(val != "" && val.length > 0){
				(function(sel, val){
					var source = root_url+"Courses/"+selectors[sel]+"/"+val;
					
					// If teacher-search: filter tutor from query and lookup course
					if(sel == ".course-finder-teacher" && val.indexOf(" | ") >= 0){
						val = val.split(" | ")[1];
						source = root_url+"Courses/byname/"+val;
					}
					
					$(sel).find("button").attr("disabled","1");
					$.getJSON(source, addCourses).always(function(){
						$(sel).find("input, select").val("");
						$(sel).find("button").removeAttr("disabled");
					});
				})(sel, val);
			}
		}
		
		event.preventDefault();
		return false;
	}).on("reset", resetCourses);
	
	$("[data-toggle='tooltip']").tooltip();
	
	$("body").on("keyup change", "input.grade, textarea", function(){ updateBar(); dirty(true); });
	
	$("input.grade").on("keyup", function(event){
    var val = this.value;

    // Ensure we only handle printable keys, excluding enter and space
    var charCode = event.which;
    if (charCode == 188) {
        var keyChar = String.fromCharCode(charCode);

        // Transform typed character
        var mappedChar = transformTypedChar(keyChar, event);

        var start, end;
        if (typeof this.selectionStart == "number" && typeof this.selectionEnd == "number") {
            // Non-IE browsers and IE 9
						debugger;
            start = this.selectionStart;
            end = this.selectionEnd;
            this.value = val.slice(0, start - 1) + mappedChar + val.slice(end);

            // Move the caret
            this.selectionStart = this.selectionEnd = start + 1;
        } else if (document.selection && document.selection.createRange) {
            // For IE up to version 8
            var selectionRange = document.selection.createRange();
            var textInputRange = this.createTextRange();
            var precedingRange = this.createTextRange();
            var bookmark = selectionRange.getBookmark();
            textInputRange.moveToBookmark(bookmark);
            precedingRange.setEndPoint("EndToStart", textInputRange);
            start = precedingRange.text.length;
            end = start + selectionRange.text.length;

            this.value = val.slice(0, start) + mappedChar + val.slice(end);
            start++;

            // Move the caret
            textInputRange = this.createTextRange();
            textInputRange.collapse(true);
            textInputRange.move("character", start - (this.value.slice(0, start).split("\r\n").length - 1));
            textInputRange.select();
        }

        return false;
    }
	});
	
	$(".jumbotron input.token").on("change, keyup", function(){
		if( $(this).val().length == 0 )
			$(".jumbotron .btn-large").attr("disabled", true);
		else
			$(".jumbotron .btn-large").removeAttr("disabled");
	}).trigger("keyup");
	
	$(window).hashchange( function(){
		if(location.hash == "#login"){
			$(".jumbotron .btn-large").popover('show');
			$(".jumbotron .btn-large, .jumbotron .token").one("click", function(){
				$(".jumbotron .btn-large").popover('hide');
			});
			location.hash = "";
		} 
	});
	$(window).hashchange();
});
function transformTypedChar(charStr, e) {
    return e.which == 188 ? "." : charStr;
}