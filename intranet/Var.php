<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$Variable = new Variable();
$Var = $_GET['Var'];

?><style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0;
	margin-right: 0px;
	margin-bottom: 0;
}
</style>
<form>
    <input type="hidden" name="<?= $Var ?>">
    <input type="text" name="<?= $Variable->view($Var); ?>">
    <input name="Guardar" type="submit" value="G" id="Guardar"  onclick="this.value='...';this.form.submit();" />
</form>