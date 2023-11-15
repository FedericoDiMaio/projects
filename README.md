# projects
online train ticket purchase and sale service, preparatory project to access my last computer engineering exam


BUG:


1- non salva gli id giusti all'interno della tabella carrozza_treno
2- posso selezionare stazioni uguali
3- utilizzare include per mettere a fattor comune connessioni header ecc

• dentro "landingCheck" ci sono due if sequenziali con la stessa condizione (li puoi accorpare in un if solo);
• idem dentro "landing";
• dentro "landing" esegui 2 volte la stessa "select * from stazione", potresti catturare il risultato in un array e iterarlo 2 volte a seguire per ridurre l'accesso al database;
• quando registri l'utente dentro "registrazioneSave.php" manca un controllo che verifichi se l'utente esiste già o meno;
• dentro "utenteAmministrativo.php" crei una connessione al DB, ma non la usi;
• dentro "utenteComposizione.php" c'è lo stesso problema degli if di cui sopra, puoi accorparli;
• idem dentro "utenteRegistrato.php";
• dentro "utenteRegistratoCheck.php" c'è la stessa situazione di cui sopra - puoi accorpare gli if, e puoi evitare di rieseguire la stessa query 4 volte (tra l'altro occhio, perché nella posizione di partenza e di destinazione ci finisce lo stesso valore, per come sono fatte le 2 query), puoi farla una volta sola e fare un unico bind dei valori;



