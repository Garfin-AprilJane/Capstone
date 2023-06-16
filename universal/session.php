<?php
    if(!empty(session_id())) {
        session_destroy();
    }
?>