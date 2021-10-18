<?php
$andmed = simplexml_load_file("andmebaas.xml");
$andmedUus = simplexml_load_file("tooted.xml");
//andmete salvestamine xml faili, kus andmed lisatakse juurde
if (isset($_POST['submit'])){
    if ($_POST['nimi'] ==null || $_POST['hind'] == null || $_POST['varv']==null || $_POST['lisa_nimi'] == null||$_POST['lisa_suurus']==null){
        echo "<script>alert('Vaja lisada andmed');</script>";
    }
    else{
        $toodenimi=$_POST['nimi'];
        $toodehind=$_POST['hind'];
        $toodevarv=$_POST['varv'];
        $toodelisanimi=$_POST['lisa_nimi'];
        $toodelisasuurus=$_POST['lisa_suurus'];

        $xml_tooded = $andmed->addChild('toode');
        $xml_tooded -> addChild('nimi',$toodenimi);
        $xml_tooded -> addChild('hind',$toodehind);
        $xml_tooded -> addChild('varv',$toodevarv);

        $lisad = $xml_tooded->addChild('lisad');
        $lisad -> addChild('nimi',$toodelisanimi);
        $lisad -> addChild('suurus',$toodelisasuurus);

        $xmlDoc = new DOMDocument("1.0","UTF-8");
        $xmlDoc->loadXML($andmed->asXML(), LIBXML_NOBLANKS);
        $xmlDoc-> formatOutput=true;
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->save("andmebaas.xml");
        header("refresh: 0;");
    }
}
// andmete salvestaine uue xml faili
if(isset($_POST['submit_uus'])) {

    $toodenimi=$_POST['nimi'];
    $toodehind=$_POST['hind'];
    $toodevarv=$_POST['varv'];
    $toodelisanimi=$_POST['lisa_nimi'];
    $toodelisasuurus=$_POST['lisa_suurus'];

    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->formatOutput = true;
    $xmlDoc->preserveWhiteSpace = false;

    $xml_root = $xmlDoc->createElement("tooted");
    $xmlDoc->appendChild($xml_root);

    $xml_toode = $xmlDoc->createElement("toode");
    $xmlDoc->appendChild($xml_toode);

    $xml_root->appendChild($xml_toode);

    $xml_toode->appendChild($xmlDoc->createElement('nimi', $toodenimi));
    $xml_toode->appendChild($xmlDoc->createElement('hind', $toodehind));
    $xml_toode->appendChild($xmlDoc->createElement('varv', $toodevarv));

    $lisad =$xmlDoc->createElement("lisad");
    $xmlDoc->appendChild($lisad);

    $xml_toode->appendChild($lisad);
    $lisad->appendChild($xmlDoc->createElement('nimi', $toodelisanimi));
    $lisad->appendChild($xmlDoc->createElement('suurus', $toodelisasuurus));

    $xmlDoc->save('tooted.xml');
}

?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XML andmete lugemine PHP abil </title>
</head>
<body>
<h1>XML andmete lugemine PHP abil sama tabelisse</h1>
<h3>Esimese toode nimi:</h3>
<?php
echo $andmed -> toode[0]-> nimi;
?>
<table>
    <tr>
        <th>Toodenimi</th>
        <th>Hind</th>
        <th>Värv</th>
        <th>Lisade nimi</th>
        <th>Lisade suurus</th>
    </tr>
    <?php
    foreach ($andmed -> toode as $toode){
        echo "<tr>";
        echo "<td>".($toode->nimi)."</td>";
        echo "<td>".($toode->hind)."</td>";
        echo "<td>".($toode->varv)."</td>";
        echo "<td>".($toode->lisad->nimi)."</td>";
        echo "<td>".($toode->lisad->suurus)."</td>";
        echo "<tr>";
    }
    ?>
</table>
<h1>Vormist saadud andmete lisamine XML faili</h1>
<form method="post" action="">
    <label for="nimi">Toode nimi</label>
    <input type="text" id="nimi" name="nimi"><br>
    <label for="hind">Toode hind</label>
    <input type="text" id="hind" name="hind"><br>
    <label for="varv">Toode varv</label>
    <input type="text" id="varv" name="varv"><br>
    <label for="Lisa_nimi">Lisa nimi</label>
    <input type="text" id="Lisa_nimi" name="lisa_nimi"><br>
    <label for="lisa_suurus">Lisa värv</label>
    <input type="text" id="lisa_suurus" name="lisa_suurus"><br>
    <input type="submit" value="Sisesta" id="submit" name="submit">
    <input type="submit" value="SisestaUus" id="submit_uus" name="submit_uus">
</form>
<h3>Esimese toode nimi:</h3>
<?php
echo $andmedUus -> toode[0]-> nimi;
?>
<h1>XML andmete lugemine PHP abil erineva tabelisse</h1>
<table>
    <tr>
        <th>Toodenimi</th>
        <th>Hind</th>
        <th>Värv</th>
        <th>Lisade nimi</th>
        <th>Lisade suurus</th>
    </tr>
    <?php
    foreach ($andmedUus -> toodeUus as $toodeUus){
        echo "<tr>";
        echo "<td>".($toodeUus->nimi)."</td>";
        echo "<td>".($toodeUus->hind)."</td>";
        echo "<td>".($toodeUus->varv)."</td>";
        echo "<td>".($toodeUus->lisad->nimi)."</td>";
        echo "<td>".($toodeUus->lisad->suurus)."</td>";
        echo "<tr>";
    }
    ?>


</table>
</body>
</html>
