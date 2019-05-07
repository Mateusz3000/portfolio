<?php
//tworzymy tablice do przechowywania błędów
$bledy=array();
//inicjujemy domyślne typ  i treść komunikatu
$komunikat="Mail został wysłany";
$type="ok";
//sprawdzamy czy wypełniono pole nazwisko i jeśli nie dodajemy do tablicy błąd
if (empty($_POST['nazwisko'])) $bledy[]="wypełnij pole 'Imię i Nazwisko'";
//sprawdzamy poprawność maila i ewentualnie dodajemy bład
$wyr = "!^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([a-zA-Z0-9_-]+)(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,4})$!i";
if (!preg_match($wyr, $_POST['mail'] )) $bledy[]="podaj poprawny adres mail";
//jak wyżej sprawdzamy czy pole nie jest puste
if (empty($_POST['wiadomosc'])) $bledy[]="wypełnij pole treści wiadomości";
//sprawdzamy czy są jakieś błędy
if ($bledy)
{
//jeśli błędy są, zmieniamy typ wiadomości i ustalamy jej nową treść
    $type="error";
    $komunikat="<ul>";
    foreach ($bledy as $b) $komunikat.="<li>".$b."</li>";
    $komunikat."</ul>";
} else
{
//jeśli nie ma błędów próbujemy wysłać maila
    $temat= "=?UTF-8?B?".base64_encode("Wiadomość ze strony internetowej mateuszportfolio.xaa.pl od ".$_POST['nazwisko'])."?=";
    $naglowki = "Reply-to:".$_POST['mail'].PHP_EOL;
    $naglowki .= "From: ".$_POST['mail'].PHP_EOL;
    $naglowki .= "MIME-Version: 1.0".PHP_EOL;
    $naglowki .= "Content-type: text/html; charset=utf-8".PHP_EOL;
    if(!mail('mateusz.drab@gmail.com', $temat, $_POST['wiadomosc'], $naglowki))
    {
        //jeśli wystąpił błąd podczas wysyłania maila zmieniamy odpowiednio typ i treść wiadomości
        $komunikat="Wystąpił błąd podczas wysyłania wiadomości";
        $type="error";
    }
}
//wyświetlamy odpowiednią wiadomość w postaci obiektu JSON
$odp=array("type"=>$type,"text"=>$komunikat);
echo json_encode($odp);
?>
