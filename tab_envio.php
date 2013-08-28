<?php
//$exp_nur = new tab_exp_nur();
//        $exp_nur->setRequest2Object($_REQUEST);
//        $exp_nur->setExn_id('');
//        $exp_nur->setExn_pass($_REQUEST['pass']);
//        $exp_nur->setExn_user($_REQUEST['user']);
//        $exp_nur->setExn_nur($_REQUEST['nuri']);
//        $exp_nur->setdep_estado(1);
//
//        $exn_id = $exp_nur->insert();
?>    

<form id="formA" name="formA" method="post" action="http://localhost/archivo-prueba/login/">

    <input name="user" type="hidden" id="user" value="<?php echo $_REQUEST['login']; ?>" />
    <input name="pass" type="hidden" id="pass" value="<?php echo $_REQUEST['pass']; ?>" />
    <input name="exn_id" type="hidden" id="exn_id" value="<?php echo $_REQUEST['exn_id'] ?>" />

    <script language="JavaScript">
        document.formA.submit();
    </script>
</form>
