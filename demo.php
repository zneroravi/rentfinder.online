 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/>remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
<form name="karan" action="" method="post">
                <div class="field_wrapper">
                    <div>
                        <input type="text" name="field_name[]" value="">
                        <a href="javascript:void(0);" class="add_button" title="Add field">add</a>
                    </div>
                </div>
                <input type="submit" name="submit" value="SUBMIT">
                </form>
<?php
print '<pre>';
print_r($_REQUEST['field_name']);
print '</pre>';
//output

?>
<?php
$field_values_array = $_REQUEST['field_name'];
foreach($field_values_array as $value){
    //your database query goes here
}
?>