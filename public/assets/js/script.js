// show loader
function loading(){ $('#loading_img').css('display','block'); }
// hide loader
function unloading(){ $('#loading_img').css('display','none'); }

// field required
function field_required(field_name,field_id,msg)
{
    var field_value = $("#"+field_id).val();
    if(field_value =="" || field_value ==undefined)
    {
        $("#"+field_name+"_validate").addClass("has-validation");
        $("#"+field_name+"_err_msg").text(msg);
        return false;
    }
    else
    {
        $("#"+field_name+"_validate").removeClass("has-validation");
        $("#"+field_name+"_err_msg").text('');
        return true;
    }
}
// ________________________________________________

// check checkBox is checked
function isChecked(checkbox_id,msg)
{
    if(!$("#"+checkbox_id).is(':checked'))
    {
        $("#"+checkbox_id+"_Error").text(msg);
        return false;
    }
    else
    {
        $("#"+checkbox_id+"_Error").text('');
        return true;
    }
}
// _________________________________________

function isCheckboxChecked(checkboxId) {
  return $("#" + checkboxId).prop("checked");
}

// check given value is valid email
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    //var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+(com)+$/;
    return regex.test(email);
}
// ___________________________________________

// check given value is valid string withour any digit
function isStringWithoutDigit(stringVal) {
    var regex = /^[a-zA-Z]+ [a-zA-Z]+$/;
    //var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+(com)+$/;
    return regex.test(stringVal);
}
// ___________________________________________

 // --------------- only integer -------------------
 $(document).on('keydown', ".only_integer", function(e) {
    //   console.log(e);
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [8,9,13,27]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
 // ---------------------------------------------------------------

  // --------------- only decimal number-------------------
  $(document).on('keydown', ".decimal", function(e) {
    //   console.log(e.keyCode); //  // 110 for allow dot(.)
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [8,9,13,27,110]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)       ) {
        e.preventDefault();
    }
});
 // ---------------------------------------------------------------

   // --------------- phonec number input -------------------
   $(document).on('keydown', ".phone_number_input", function(e) {
    //   console.log(e.keyCode); //  // 109 for allow dot(-)
   // Allow: backspace, delete, tab, escape, enter and .
   if ($.inArray(e.keyCode, [8,9,13,27,109]) !== -1 ||
        // Allow: Ctrl+A, Command+A
       (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
       (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
   }
   // Ensure that it is a number and stop the keypress
   if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)       ) {
       e.preventDefault();
   }
});
// ---------------------------------------------------------------



$(".rightClickDisabled").on("contextmenu",function(){	return false;	}); // right click disabled
$(".keyBoardFalse").keypress(function(){	return false;	}); // all key press disabled
$('.keyBoardFalse').on("cut copy paste",function(e) {	e.preventDefault();	}); // cut copy and paste disabled

// check max val
function checkMaxVal(value,maxval) {
    if(value > maxval)
       return false;
    else
        return true;
}
// ___________________________________________

// check min val
function checkMinVal(value,minval) {
    if(value < minval)
       return false;
    else
        return true;
}
// ___________________________________________

$(document).on('keyup','.setmaxval',function(){
    var value = parseFloat($(this).val());
    var maxval = parseFloat($(this).attr('data-maxval'));
    if(value > maxval)
         $(this).val(maxval);
});

$(document).on('keyup','.setmaxvalInt',function(e){
    var value = parseInt($(this).val());
    var maxval = parseInt($(this).attr('data-maxval'));
    if(value > maxval)
         $(this).val(maxval);
});


$(document).on('keyup','.setminval',function(){
    var value = parseInt($(this).val());
    var minval = parseInt($(this).attr('data-minval'));
    if(value < minval || $(this).val() =='')
         $(this).val(minval);
        //  $(this).val(minval);
});

/* $(document).on('keyup','.setmaxtxt',function(){
    var value = $(this).text();
    var maxtxt = parseFloat($(this).attr('data-maxtxt'));
    if(value > maxval)
         $(this).val(maxval);
}); */

// check max length
function checkMaxLength(value,maxlen) {
    valueLen = value.length;
    if(valueLen > maxlen)
        return false;
    else
        return true;
}
// ___________________________________________

// check min length
function checkMinLength(value,minlen) {
    valueLen = value.length;
    if(valueLen < minlen)
        return false;
    else
       return true;
}
// ___________________________________________

// check exact length
function checkExactLength(value,exactlen) {
    valueLen = value.length;
    if(valueLen == exactlen)
        return true;
    else
       return false;
}
// ___________________________________________

// check is equal to
function checkIsEqual(value1,value2) {
    if(value1 == value2)
        return true;
    else
        return false;
}
// ___________________________________________

// set error box & error msg
function setErrorAndErrorBox(field_name,msg)
{
        $("#"+field_name+"_validate").addClass("has-validation");
        $("#"+field_name+"_err_msg").text(msg);
        return false;
}
// ________________________________________________

// unset error box & error msg
function unsetErrorAndErrorBox(field_name)
{
        $("#"+field_name+"_validate").removeClass("has-validation");
        $("#"+field_name+"_err_msg").text('');
        return true;
}
// ________________________________________________
