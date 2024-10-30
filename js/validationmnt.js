// JavaScript Document

jQuery(document).ready(function() {
	  
  jQuery('#btn_submit').click(function () {
	  var flag=true;
	 var sComapreUrl =	jQuery('#redirect_url').val();
	 var sCUrlcheck  = jQuery('#urlch').val();

	 if(jQuery('input[name$="wpspandntset[pageurl]"]:checked').val()=='url')
	 {  
	    jQuery(".validurl").each(function (i) {
		  // alert('sdsd');
        
         if(jQuery(this).val()==/^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/ || jQuery(this).val()=='')
         {
			flag=false;
			jQuery(this).addClass('tb_err');
         }
		else
		{
			jQuery(this).removeClass('tb_err');
		}
       });
	   
	 
	if(flag)
	{
		document.getElementById("cntdownform").submit();
	}
    else
    {
         return false;
    }}
  });
});