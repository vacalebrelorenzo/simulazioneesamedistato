# simulazioneesamedistato - Sistema di Noleggio Biciclette

Questo progetto è un'applicazione web per il noleggio di biciclette, che permette agli utenti di registrarsi, gestire le proprie informazioni e noleggiare biciclette da diverse stazioni nella città.

## Struttura del Database

Il sistema utilizza un database per memorizzare varie informazioni, tra cui:

- **Biciclette:** Contiene dettagli sulle biciclette, come l'ID, i chilometri percorsi e la posizione.
- **Carte di Credito:** Memorizza le informazioni delle carte di credito degli utenti.
- **Utenti:** Contiene i dati degli utenti, come nome, email e ruolo.
- **GPS:** Gestisce le informazioni sui dispositivi GPS delle biciclette.
- **Indirizzi:** Conserva dettagli sugli indirizzi degli utenti.
- **Smart Cards:** Contiene dati sulle smart card degli utenti.

## Funzionalità Principali

- **Registrazione Utente:** Gli utenti possono creare un account fornendo le proprie informazioni personali.
- **Gestione Carte di Credito:** Gli utenti possono aggiungere le informazioni delle carte di credito per i pagamenti.
- **Ruolo Amministratore:** Gli amministratori hanno accesso a funzionalità speciali, come la gestione delle stazioni e delle biciclette.
- **Gestione Biciclette e Stazioni:** Le biciclette e le stazioni possono essere gestite per monitorare lo stato di noleggio e la disponibilità.

## Struttura del Progetto

Il progetto è organizzato in tre pagine principali:

- **index.html:** La homepage del sistema, che mostra la mappa delle stazioni e consente l'accesso agli utenti.
- **adminPage.php:** Una pagina riservata agli amministratori per gestire le stazioni e le biciclette.
- **userPage.php:** Una pagina dedicata agli utenti registrati, dove possono visualizzare e modificare le proprie informazioni.

## Requisiti Tecnici

Per sviluppare e eseguire il progetto sono necessari i seguenti strumenti e tecnologie:

- **Linguaggi:** HTML, CSS, JavaScript, PHP
- **Librerie:** jQuery, Leaflet.js
- **Framework:** Bootstrap

## Setup del Progetto

Per avviare il progetto, è necessario configurare un ambiente di sviluppo con un server web che supporti PHP e un database MySQL. È inoltre necessario collegare il progetto a un database MySQL contenente le tabelle e i dati necessari per il funzionamento del sistema.

