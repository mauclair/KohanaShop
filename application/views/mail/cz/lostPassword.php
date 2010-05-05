Dobrý den,

obrdželi jsme žádost o získání nového hesla k účtu
uživatele <?= $name?>. Pokud si přejete změnit heslo navštivte následující odkaz.

<?= url::site('register/confirmLostPassword/'.$LPToken)?>

Pokud tato žádost nevzešla od Vás informujte nás obratem, nebo můžete
tento email úplně ignorovat. Heslo nebude změněno dokud nenvštívíte
výše uvedený odkaz.

Vaše nové heslo je: <?= $new_password?>

Heslo si můžete změnit po přihlášení v nastavení svého účtu.

S pozdravem
<?= Options_Model::ret('site-name')?>