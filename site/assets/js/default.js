    $(document.body).getElements("a.targetblank").setProperty("target","_blank");
    $("fidal").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","fidal");
        $("athlete_selectors").getElements("img").setStyle("display", "none");
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "none");
        $("name_container").setStyle("display", "none");
        $("sex_container").setStyle("display", "none");
        $("citizenship_container").setStyle("display", "none");
        $("address_container").setStyle("display", "none");
        $("phone_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "none");
        $("medical_certificate_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "block");
        $("group_fidal_container").setStyle("display", "none");
        $("health_form_image").setStyle("display", "block");
        $("game_card_image").setStyle("display", "block");
        $("game_card_label").setStyle("display", "block");
        $("other_ass_card_label").setStyle("display", "none");
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
    $$(".add_member").addEvent("click", function(){
     el = $$(".group_member").pop().clone(true,true);
     el.getElements("input").set("value","");
     $("group_fidal_container").adopt(el); 
     hide_show_remove();
     group_billing_amount();
     event_add_element();
     return false;
     });
     $("num_tes").addEvent("blur", function(){
         if(/^[0-9]{8}$/.test($("num_tes").get("value")) == false) {
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText("Numero di tessera errato");
                    $("num_tes").addClass("wrong_field");
                    $("num_tes").grab(el,"after");
         }
         else {
             $("num_tes").removeClass("wrong_field");
             next = $("num_tes").getNext();
             if(next !== null && next.tagName == "P") {
                next.destroy();
             }
         }
     });
     /**
      * Recreates the event click on remove button
      */
    function event_add_element() {
        $$(".remove_memeber").removeEvents("click").addEvent("click", function(){
         this.getParent().getParent().destroy();
         hide_show_remove();
         group_billing_amount();
         return false;
        });
        $("group_fidal_container").getElements("input").removeEvents("blur").addEvent("blur", function(){
         check_empty_input();
         return false;
        });
        check_empty_input ();
     }
     /**
      * Calcolates the billing amount for the group
      */
     function group_billing_amount() {
        $("billing_group").set("text","L'importo dovuto è di "+($$(".group_member").length+1)*maraton_amount+" €"); 
     }
     /**
      * Check if there is an empty group memeber
      * @returns {Boolean}
      */
     function check_empty_input () {
         status = true;
         if ($("type_of_check").get("value") != "group_fidal") 
             return status;
         num_tes_coll=[$("num_tes").get("value")];
         $("registration").getElements("p").destroy();
         input_coll = $("group_fidal_container").getElements("input");
         for (var i=0;i<input_coll.length;i++) {
             if(input_coll[i].get("value") == "") {
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText("Nome e numero di tessera sono richiesti");
                    $(input_coll[i]).addClass("wrong_field");
                    $(input_coll[i]).grab(el,"after");
                    status = false;
             }
             if(input_coll[i].get("name") == "member_num_tes[]") {
                 if(/^[0-9]{8}$/.test(input_coll[i].get("value")) == false) {
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText("Numero di tessera errato");
                    $(input_coll[i]).addClass("wrong_field");
                    $(input_coll[i]).grab(el,"after");
                    status = false;
                 }
                 if (num_tes_coll.contains(input_coll[i].get("value"))){
                    el = new Element("p");
                    el.addClass("error");
                    el.appendText("Numero di tessera già presente nel gruppo");
                    $(input_coll[i]).addClass("wrong_field");
                    $(input_coll[i]).grab(el,"after");
                    status = false;
                 }
                 num_tes_coll.push(input_coll[i].get("value"));
             }
             
         }
         return status;
     }
     event_add_element();
     $("group_fidal").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","group_fidal");
        $("athlete_selectors").getElements("img").setStyle("display", "none");
        $(this).getElements("img").removeProperty("style");
        $("registration").setStyle("display", "block");
        $("choose_athlete").setStyle("display", "none");
        $("game_card_container").setStyle("display", "none");
        $("name_container").setStyle("display", "none");
        $("sex_container").setStyle("display", "none");
        $("citizenship_container").setStyle("display", "none");
        $("address_container").setStyle("display", "none");
        $("phone_container").setStyle("display", "block");
        $("other_num_tes_container").setStyle("display", "none");
        $("medical_certificate_container").setStyle("display", "none");
        $("num_tes_container").setStyle("display", "block");
        $("group_fidal_container").setStyle("display", "block");
        $("health_form_image").setStyle("display", "block");
        $("game_card_image").setStyle("display", "block");
        $("game_card_label").setStyle("display", "block");
        $("other_ass_card_label").setStyle("display", "none");
        return false;
    });
    $("other_ass").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","other_ass");
        $("athlete_selectors").getElements("img").setStyle("display", "none");
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
        $("health_form_image").setStyle("display", "none");
        $("game_card_image").setStyle("display", "none");
        $("game_card_label").setStyle("display", "none");
        $("other_ass_card_label").setStyle("display", "block");
        return false;
    });
    $("amateur").addEvent("click", function(){
        $$("input.wrong_field").removeClass("wrong_field");
        $("registration").getElements("p").destroy();
        $("type_of_check").set("value","amateur");
        $("athlete_selectors").getElements("img").setStyle("display", "none");
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
        $("health_form_image").setStyle("display", "block");
        $("game_card_image").setStyle("display", "block");
        $("game_card_label").setStyle("display", "block");
        $("other_ass_card_label").setStyle("display", "none");
        return false;
    });
    $("submit").addEvent("click", function(){
         var status = check_empty_input ();
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


