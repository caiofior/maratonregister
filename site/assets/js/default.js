    $(document.body).getElements("a.targetblank").setProperty("target","_blank");
    $("fidal").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","fidal");
        $("registration").getElements("img").setStyles({
            opacity:"0.6",
            filter:"alpha(opacity=40)"
        });
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "none");
        $("name_container").setStyle("display", "none");
        $("sex_container").setStyle("display", "none");
        $("citizenship_container").setStyle("display", "none");
        $("address_container").setStyle("display", "none");
        $("phone_container").setStyle("display", "none");
        $("other_num_tes_container").setStyle("display", "none");
        $("medical_certificate_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "block");
        $("group_fidal_container").setStyle("display", "none");
        return false;
    });
    /**
     * Hides or shows  remove button
     */
    function hide_show_remove() {
     if ($$(".group_member").length > 1)
        $$(".remove_memeber_container").setStyle("display", "block");
     else
        $$(".remove_memeber_container").setStyle("display", "none");
    }
    $$(".add_memeber").addEvent("click", function(){
     el = $$(".group_member").pop().clone(true,true);
     el.getElements("input").set("value","");
     $("group_fidal_container").adopt(el); 
     hide_show_remove();
     event_add_element();
     return false;
     });
     /**
      * Recreates the event click on remove button
      */
    function event_add_element() { 
        $$(".remove_memeber").removeEvents("click").addEvent("click", function(){
         this.getParent().getParent().destroy();
         hide_show_remove();
         return false;
        });
     }
     event_add_element();
     $("group_fidal").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","group_fidal");
        $("registration").getElements("img").setStyles({
            opacity:"0.6",
            filter:"alpha(opacity=40)"
        });
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "none");
        $("name_container").setStyle("display", "none");
        $("sex_container").setStyle("display", "none");
        $("citizenship_container").setStyle("display", "none");
        $("address_container").setStyle("display", "none");
        $("phone_container").setStyle("display", "none");
        $("other_num_tes_container").setStyle("display", "none");
        $("medical_certificate_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "block");
        $("group_fidal_container").setStyle("display", "block");
        return false;
    });
    $("other_ass").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","other_ass");
        $("registration").getElements("img").setStyles({
            opacity:"0.6",
            filter:"alpha(opacity=40)"
        });
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "block");
        $("name_container").setStyle("display", "block");
        $("sex_container").setStyle("display", "block");
        $("citizenship_container").setStyle("display", "block");
        $("address_container").setStyle("display", "block");
        $("phone_container").setStyle("display", "block");
        $("medical_certificate_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "block");
        $("num_tes_container").setStyle("display", "none");
        $("group_fidal_container").setStyle("display", "none");
        return false;
    });
    $("amateur").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","amateur");
        $("registration").getElements("img").setStyles({
            opacity:"0.6",
            filter:"alpha(opacity=40)"
        });
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "block");
        $("name_container").setStyle("display", "block");
        $("sex_container").setStyle("display", "block");
        $("citizenship_container").setStyle("display", "block");
        $("address_container").setStyle("display", "block");
        $("phone_container").setStyle("display", "block");
        $("medical_certificate_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "none");
        $("group_fidal_container").setStyle("display", "none");
        return false;
    });
    $("submit").addEvent("click", function(){
         var status = true;
         $$("input.wrong_field").removeClass("wrong_field");
         $("registration").getElements("p").destroy();
         new Request.JSON({
            async:false,
            url:$("registration").get("action")+"&submit=1&xhr=1&medical_certificate="+$("medical_certificate").get("value"),
            data: $("registration").toQueryString(),
            onSuccess: function (responseJSON) {
                Object.each(responseJSON,function(object,id) {
                    status = false;
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText(object.message);
                    $(id).addClass("wrong_field");
                    $(id).grab(el,"after");
                });
                
            }
         }).send();
        return status;
    });
    function initFileUploads() {
	var fakeFileUpload = document.createElement("a");
        fakeFileUpload.setAttribute("href","#");
        container = document.createElement("span");
        container.innerHTML = "Scegli il documento";
        fakeFileUpload.appendChild(container);
	var x = document.getElementsByTagName("input");
	for (var i=0;i<x.length;i++) {
		if (x[i].type != "file") continue;
		if (x[i].parentNode.className != "fileinputs") continue;
		var clone = fakeFileUpload.cloneNode(true);
                x[i].setAttribute("style","display:none;");
		x[i].parentNode.appendChild(clone);
                clone.onclick = function () {
                        this.parentNode.getElementsByTagName("input")[0].click();
                        return false;
                }
                x[i].onpropertychange =  function() {
                    this.parentNode.getElementsByTagName("a")[0].getElementsByTagName("span")[0].innerHTML = this.value;
                };
                x[i].onchange = function() {
                    this.parentNode.getElementsByTagName("a")[0].getElementsByTagName("span")[0].innerHTML = this.value;
                };

            }
    }
    initFileUploads();


