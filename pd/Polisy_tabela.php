<?php
	session_name("PD");
	session_start();
?>
<!DOCTYPE html>
<html class="" lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Dariusz Bieniek">
	<meta name="viewport" content="width=device-width">
	<title>Strefa agenta</title>
	<link href="pliki/style.css" rel="stylesheet">
</head>

<body>	
	

 <?php	

if (!isset($_SESSION["zalogowany"])||$_SESSION["zalogowany"] == false||!isset($_SESSION["uzytkownik"])) {
	die("<p class='blad'>Ta funkcja jest dostępna tylko dla zalogowanych użytkowników.</p>
	<p><a href='logowanie.php'>Przejdź do formularza logowania.</a></p>");
}
else if ($_SESSION["zalogowany"] == true&& isset($_SESSION["uzytkownik"])) {

    // Włączenie kodu PHP realizuj±cego połązenie z serwerem baz danych.
	require_once("polaczenie.php");
 
 
  

try
	{
		print("	
	 
	<figure>
	<figcaption> </figcaption>
	<table>
	<caption><h3>Polisy</h3></caption>
	
 
		<thead>
				
			<tr>
		
				<th><a href='Polisy_tabela.php?sortuj=NrPolisy'>Numer Polisy</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Agent'>Agent</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Indywidualny'>Klient indywidualny</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Firma'>Firma</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Produkt'>Produkt</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Kategoria'>Kategoria</a></th>
				<th><a href='Polisy_tabela.php?sortuj=OdKogo'>Od Kogo</a></th>
				<th><a href='Polisy_tabela.php?sortuj=StatusSkladki'>Status Skladki</a></th>
				<th><a href='Polisy_tabela.php?sortuj=Skladka'>Składka</a></th>
				<th><a href='Polisy_tabela.php?sortuj=RodzajSkladki'>Rodzaj</a></th>
				<th><a href='Polisy_tabela.php?sortuj=OdKiedy'>Początek polisy</a></th>
				<th><a href='Polisy_tabela.php?sortuj=DoKiedy'>Koniec polisy</a></th>
				<td></td>
				<td></td>
			</tr>
		</thead>");
					  
		$stmt = $db->query("SELECT T1.NumerPolisy, CONCAT_WS(' ', T2.Imie, T2.Nazwisko) AS Agent, CONCAT_WS(' ', T3.Imie, T3.Nazwisko) AS Klientindywidualny, T4.Nazwa AS Firma, T6.Nazwa AS Produkt, T8.Nazwa AS Kategoria, T7.Nazwa AS OdKogo, T9.Nazwa As StatusSkladki, Skladka, RodzajSkladki AS Rodzaj, T5.OdKiedy, T5.DoKiedy FROM polisy T1
  INNER JOIN agenci T2
   ON T1.IdAgenta = T2.IdAgenta 	
    LEFT OUTER JOIN klienciindywidualni T3
     ON T1.IdKlientaIndywidualnego = T3.IdKlientaIndywidualnego
	  LEFT OUTER JOIN kliencifirmy T4
	  ON T1.IdKlientaFirmy = T4.IdKlientaFirmy
		 INNER JOIN polisyprodukty T5
          ON T1.NumerPolisy = T5.NumerPolisy
           INNER JOIN produkty T6
            ON T5.IdProduktu = T6.IdProduktu
	         INNER JOIN dostawcyproduktow T7
	          ON T6.IdDostawcyProduktow = T7.IdDostawcyProduktow
	           INNER JOIN kategorieproduktow T8
	            ON T6.IdKategoriiProduktow = T8.IdKategoriiProduktow
		         INNER JOIN statusskladek T9
		          ON T1.IdStatusuSkladek = T9.IdStatusuSkladek");
	  foreach( $stmt->fetchAll() as $value )
     {
		
	print '<tr>';
	print'<td>'.$value['NumerPolisy'].'</td>';
	print'<td>'.$value['Agent'].'</td>';
    print'<td>'.$value['Klientindywidualny'].'</td>';
	print'<td>'.$value['Firma'].'</td>';
    print'<td>'.$value['Produkt'].'</td>';
	print'<td>'.$value['Kategoria'].'</td>';
    print'<td>'.$value['OdKogo'].'</td>';
	print'<td>'.$value['StatusSkladki'].'</td>';
    print'<td>'.$value['Skladka'].'</td>';
	print'<td>'.$value['Rodzaj'].'</td>';
	print'<td>'.$value['OdKiedy'].'</td>';
	print'<td>'.$value['DoKiedy'].'</td>';
   	print'<td><a href="Polisy_edycja.php?id=' . $value['NumerPolisy'] . '">Edytuj</a></td>';
	print'<td><a href="Polisy_usuwanie.php?id=' . $value['NumerPolisy'] . '">Usun</a></td>';
	
	print'</tr>';
        
}
$stmt->closeCursor();
	print("</tbody>");
	print("</table>");

	}#try
	  
	
	
	catch(Exception $e)
	{
		print(print_r($e->getMessage()));
	}#catch
	// Sekcja wykonywana zawsze.
//	finally
//	{
		
//		$polaczenie = null;
//	}#finally
	print("<a href='tabele.php'><h2>Zarządzanie bazą</h2></a>");
     print("<a href='logowanie_koniec.php'><h2>Wyloguj</h2></a>");
	NowaPolisa();

}//else if		

 function NowaPolisa()
{	
print('<br />');
print("		
	
 
 </table>
 
 
 </figure>
 
 <h3>Dodawanie polisy</h3>
 
		<form id='polisa' method='get' action='Polisy_dodawanie.php'>
 

		<fieldset>
			<legend>Polisa</legend>
			
		<p>Wybor rodzaju klienta:</p>			
			<p>
				<input type='radio' name='rodzaj_klienta' value='indywidualny' checked='checked' />Klient indywidualny
			</p>
			
			<p>
			
			<input type='radio' name='rodzaj_klienta' value='firma' />Klient firma
			
		
 
			<p>
				<input type='submit' value='Nowa polisa' />

				
			</p>
		</fieldset>
</form>
	 ");
	}
	 print("<a href='tabele.php'><h2>Zarządzanie bazą</h2></a>");
     print("<a href='logowanie_koniec.php'><h2>Wyloguj</h2></a>");


 ?>

</body></html>