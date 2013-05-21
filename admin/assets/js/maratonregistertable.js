el = $("payment_filter_check").getChildren("span");
input = $("payment_filter");
if (input.get("value")==1)
       el.removeClass("disabled").addClass("publish");
else if (input.get("value") == 0 && input.get("value").length > 0)
       el.removeClass("disabled").addClass("unpublish");
$("payment_filter_check").addEvent("click",function() {
input = $("payment_filter");
if (input.get("value")=="")
       input.set("value",1);
else if (input.get("value")==1)
       input.set("value",0);
else
       input.set("value","");
$("adminForm").submit();
});

el = $("medical_certificate_filter_check").getChildren("span");
input = $("medical_certificate_filter");
if (input.get("value")==1)
       el.removeClass("disabled").addClass("publish");
else if (input.get("value") == 0 && input.get("value").length > 0)
       el.removeClass("disabled").addClass("unpublish");
$("medical_certificate_filter_check").addEvent("click",function() {
        el = this.getChildren("span");

        input = $("medical_certificate_filter");
        if (input.get("value")=="")
               input.set("value",1);
        else if (input.get("value")==1)
               
               input.set("value",0);
        else 
               input.set("value","");
        $("adminForm").submit();
        });
el = $("pectoral_filter_check").getChildren("span");
input = $("pectoral_filter");
if (input.get("value")==1)
       el.removeClass("disabled").addClass("publish");
else if (input.get("value") == 0 && input.get("value").length > 0)
       el.removeClass("disabled").addClass("unpublish");
$("pectoral_filter_check").addEvent("click",function() {
        el = this.getChildren("span");
        input = $("pectoral_filter");
        if (input.get("value")=="") 
               input.set("value",1);
        else if (input.get("value")==1) 
               input.set("value",0);
        else 
               input.set("value","");
        $("adminForm").submit();
        });