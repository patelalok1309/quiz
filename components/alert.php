<?php
function alert($alerttype, $message)
{
    return "<div class='alert alert-$alerttype alert-dismissible fade show' role='alert'> 
    <strong> $alerttype </strong>
    $message
    <button type='button' class='close btn-close ' data-bs-dismiss='alert' aria-label='close'>
    <span aria-hidden='true'> </span>
    </button> 
     </div>";
}

?>