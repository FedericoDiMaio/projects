# projects
online train ticket purchase and sale service, preparatory project to access my last computer engineering exam


BUG:


1- non salva gli id giusti all'interno della tabella carrozza_treno
2- posso selezionare stazioni uguali
3- utilizzare include per mettere a fattor comune connessioni header ecc




• dentro "utenteRegistratoCheck.php" c'è la stessa situazione di cui sopra - puoi accorpare gli if, e puoi evitare di rieseguire la stessa query 4 volte (tra l'altro occhio, perché nella posizione di partenza e di destinazione ci finisce lo stesso valore, per come sono fatte le 2 query), puoi farla una volta sola e fare un unico bind dei valori;



