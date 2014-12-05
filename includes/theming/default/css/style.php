<?php
if(filter_var($urlim, FILTER_VALIDATE_URL) == true) {
?>
<style>
#eps_popup_left {
float: left;
width: 60%;
padding-right: 2% !important;
}

#tm_container {
bottom: 0;
}

</style>
<?php
} else {
?>
<style>
#eps_popup_left {
width: auto;
}


#tm_container {
bottom: 1%;
}

</style>
<?php
}
?>