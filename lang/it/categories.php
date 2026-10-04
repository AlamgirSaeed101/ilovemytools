<?php

return [
    'text-tools' => [
        'name' => 'Strumenti per il testo',
        'short' => 'Testo',
        'subtitle' => 'Conta e converti i tuoi testi',
        'title' => 'Strumenti per il testo gratuiti: contaparole e maiuscole',
        'description' => 'Strumenti online gratuiti per contare parole e caratteri, cambiare maiuscole e minuscole e rifinire i tuoi testi. Risultati immediati, senza registrazione.',
        'intro' => 'Conta le parole, controlla il tempo di lettura e converti maiuscole e minuscole all’istante. Tutto funziona nel tuo browser, quindi il testo resta privato.',
        'content' => [
            ['heading' => 'Quale strumento per il testo mi serve?', 'body' => 'Usa il Contaparole quando devi rispettare un limite: temi, lettere di presentazione, descrizioni di prodotti, post sui social o meta tag SEO. Conta parole, caratteri con e senza spazi, frasi e paragrafi e stima il tempo di lettura e di esposizione. Usa il Convertitore maiuscole/minuscole quando le parole vanno bene ma le maiuscole no: testo scritto con il Bloc Maiusc attivo, titoli o nomi di variabili in camelCase o snake_case.'],
            ['heading' => 'Questi strumenti per il testo sono privati?', 'body' => 'Entrambi funzionano interamente nel tuo browser. Il testo che incolli viene elaborato sul tuo dispositivo e non viene mai inviato al nostro server né salvato, quindi puoi usarli con bozze, email e documenti riservati. Una volta caricata la pagina, continuano a funzionare anche se la connessione cade.'],
        ],
        'faqs' => [
            ['q' => 'Come conto le parole di un documento?', 'a' => 'Copia il testo da Word, Google Documenti o un PDF e incollalo nel Contaparole. I totali si aggiornano subito, con caratteri, frasi, paragrafi e tempo di lettura.'],
            ['q' => 'Come trasformo un testo da maiuscolo a minuscolo?', 'a' => 'Incolla il testo nel Convertitore e scegli minuscolo. Puoi anche passare a Iniziali Maiuscole, maiuscola iniziale, camelCase, snake_case e altro, poi copiare il risultato.'],
            ['q' => 'Questi strumenti per il testo costano qualcosa?', 'a' => 'No. Sono entrambi gratuiti, senza registrazione, senza limiti giornalieri e senza limiti di lunghezza del testo.'],
        ],
    ],
    'image-tools' => [
        'name' => 'Strumenti per immagini',
        'short' => 'Immagini',
        'subtitle' => 'Comprimi, ridimensiona e converti',
        'title' => 'Strumenti per immagini gratis: comprimi e ridimensiona',
        'description' => 'Comprimi, ridimensiona e converti gratis immagini JPG, PNG e WebP. Le immagini vengono elaborate nel browser e non vengono mai caricate su un server.',
        'intro' => 'Alleggerisci le immagini, ridimensiona le foto a misure esatte e converti tra JPG, PNG e WebP. Le tue immagini non lasciano mai il dispositivo.',
        'content' => [
            ['heading' => 'Devo comprimere o ridimensionare l’immagine?', 'body' => 'Comprimi quando l’immagine va bene ma il file è troppo pesante, per esempio per restare sotto un limite di caricamento come 100 KB o per velocizzare una pagina web: il Compressore di immagini mantiene le dimensioni e riduce il peso. Ridimensiona quando le dimensioni sono sbagliate, come una foto di 4000 pixel che deve essere larga 1080 pixel per i social. Rimpicciolire una foto grande riduce molto anche il peso del file.'],
            ['heading' => 'JPG, PNG o WebP: quale formato è migliore?', 'body' => 'Il JPG è il migliore per le foto, il PNG per loghi, screenshot e tutto ciò che richiede trasparenza, e il WebP per il web, perché produce i file più leggeri in entrambi i casi. Secondo Google, le immagini WebP senza perdita sono circa il 26% più leggere dei PNG, e quelle con perdita dal 25 al 34% più leggere di JPEG equivalenti.'],
        ],
        'faqs' => [
            ['q' => 'Come riduco un’immagine a 100 KB?', 'a' => 'Apri il Compressore di immagini, scegli Dimensione obiettivo e inserisci 100. Lo strumento trova la qualità migliore che rientra nel limite e riduce le dimensioni solo se serve.'],
            ['q' => 'Posso convertire PNG in JPG o WebP in PNG qui?', 'a' => 'Sì. Lo strumento per ridimensionare e convertire passa da JPG a PNG e WebP, con o senza ridimensionamento. Le aree trasparenti diventano bianche quando salvi in JPG.'],
            ['q' => 'Le mie foto vengono caricate su un server?', 'a' => 'No. Le immagini vengono elaborate nel browser con l’API Canvas e non lasciano mai il tuo dispositivo.'],
        ],
    ],
    'pdf-tools' => [
        'name' => 'Strumenti PDF',
        'short' => 'PDF',
        'subtitle' => 'Unisci, converti, comprimi e proteggi PDF',
        'title' => 'Strumenti PDF gratuiti: unire, convertire, modificare',
        'description' => 'Unisci, dividi, converti, comprimi e proteggi file PDF online gratis. Senza caricamenti, senza filigrane, senza registrazione: tutto nel browser.',
        'intro' => 'Un toolkit PDF completo che non carica mai i tuoi file: unisci o dividi documenti, ruota, riordina ed elimina pagine, trasforma i PDF in JPG, PNG, Word o Excel (e viceversa), converti HTML o testo semplice in PDF, riduci file grandi, e aggiungi o rimuovi una password di apertura. Ogni strumento elabora il tuo documento sul tuo dispositivo, senza filigrane, senza limiti di pagine e senza trucchi sulla dimensione.',
        'content' => [
            ['heading' => 'Quale strumento PDF mi serve?', 'body' => 'Usa Unisci PDF per riunire più file in un documento nell’ordine che preferisci, per esempio curriculum, lettera di presentazione e certificati per una candidatura, e Dividi PDF per il contrario: estrarre pagine in un nuovo file, tagliare un documento per intervalli o salvare ogni pagina come PDF separato. Ruota PDF corregge le pagine storte, Elimina pagine PDF rimuove quelle indesiderate, e Organizza PDF riordina un intero documento trascinando le miniature delle pagine. Comprimi PDF riduce un file troppo grande da inviare per email, e Proteggi PDF / Sblocca PDF aggiungono o rimuovono una password di apertura.'],
            ['heading' => 'Convertire i PDF in altri formati e viceversa', 'body' => 'PDF in Word e PDF in Excel estraggono il testo (e, in Excel, righe e colonne) di un PDF in un file .docx o .xlsx modificabile, mentre Word in PDF ed Excel in PDF fanno il contrario: trasformano un documento Word o un foglio di calcolo in un PDF fisso che appare uguale ovunque. PDF in JPG e PDF in PNG salvano le pagine come immagini, e HTML in PDF trasforma HTML incollato o testo semplice in un PDF scaricabile. Queste conversioni sono una stima: testo e struttura di base vengono conservati bene, ma layout esatto, tabelle, grafici e font non sempre vengono mantenuti; ogni strumento spiega esattamente cosa aspettarsi.'],
            ['heading' => 'È sicuro modificare i PDF online?', 'body' => 'Con la maggior parte dei siti PDF il documento viene caricato su un server prima che accada qualsiasi cosa. Qui ogni strumento funziona nel tuo browser con JavaScript, quindi contratti, estratti conto, documenti Word e foglio di calcolo non lasciano mai il tuo dispositivo, e i risultati non hanno filigrane né limiti di pagine.'],
        ],
        'faqs' => [
            ['q' => 'Come unisco più PDF in uno solo?', 'a' => 'Apri Unisci PDF, aggiungi due o più file, mettili in ordine con le frecce e clicca Unisci PDF. Il file combinato si scarica subito.'],
            ['q' => 'Come estraggo pagine da un PDF?', 'a' => 'Apri Dividi PDF, scegli Estrai pagine, scrivi le pagine che ti servono, per esempio 1-3, 5, e clicca Dividi PDF.'],
            ['q' => 'Posso convertire un PDF in un file Word o Excel modificabile?', 'a' => 'Sì: PDF in Word e PDF in Excel estraggono il testo (e, in Excel, le sue righe e colonne) come stima. Layout complessi, tabelle, colonne e immagini non sempre vengono mantenuti, come spiega ogni strumento.'],
            ['q' => 'Posso unire PDF protetti da password?', 'a' => 'Non direttamente. Apri il file con la password, salva o stampa una copia non protetta e poi unisci quella copia. Puoi anche usare prima Sblocca PDF se conosci la password.'],
            ['q' => 'I miei file vengono caricati su un server?', 'a' => 'No. Tutti gli strumenti PDF di questo sito elaborano i tuoi file localmente nel tuo browser con JavaScript, quindi non vengono mai caricati né salvati.'],
        ],
    ],
    'calculators' => [
        'name' => 'Calcolatrici',
        'short' => 'Calcolatrici',
        'subtitle' => 'I calcoli di tutti i giorni',
        'title' => 'Calcolatrici online gratuite: età e percentuali',
        'description' => 'Calcolatrici online gratuite per età, percentuali, variazioni percentuali e altro. Risposte esatte e immediate con il calcolo spiegato.',
        'intro' => 'Calcolatrici veloci e precise per i conti di tutti i giorni: età esatta, percentuali, aumenti e sconti.',
        'content' => [
            ['heading' => 'Cosa calcolano queste calcolatrici?', 'body' => 'Il Calcolatore di età fornisce l’età esatta in anni, mesi e giorni da una data di nascita, il giorno della settimana in cui sei nato e il conto alla rovescia per il prossimo compleanno, tenendo conto degli anni bisestili. Il Calcolatore di percentuali riunisce le domande più comuni: il X% di Y, che percentuale è X di Y, l’aumento o la diminuzione percentuale tra due numeri e l’aggiunta o la sottrazione di una percentuale, come uno sconto o una tassa.'],
            ['heading' => 'Come verifico il risultato?', 'body' => 'Ogni risultato mostra la formula usata, così puoi seguire il calcolo per compiti, sconti, aumenti di stipendio o report. Per esempio, la variazione percentuale da 80 a 100 è (100 - 80) / 80 x 100 = 25%.'],
        ],
        'faqs' => [
            ['q' => 'Come si calcola esattamente l’età?', 'a' => 'Prima si contano gli anni compiuti, poi i mesi completi e infine i giorni rimanenti. È lo stesso metodo dei moduli ufficiali.'],
            ['q' => 'Come calcolo un aumento percentuale?', 'a' => 'Sottrai il valore vecchio da quello nuovo, dividi per il valore vecchio e moltiplica per 100. Il Calcolatore di percentuali lo fa per te e mostra la formula.'],
            ['q' => 'Le calcolatrici sono gratuite?', 'a' => 'Sì. Sono gratuite, senza registrazione, e funzionano nel tuo browser, quindi nulla di ciò che inserisci viene salvato.'],
        ],
    ],
    'generators' => [
        'name' => 'Generatori',
        'short' => 'Generatori',
        'subtitle' => 'Codici QR e password',
        'title' => 'Generatori gratuiti: codici QR e password sicure',
        'description' => 'Genera gratis codici QR per link e Wi-Fi e password casuali sicure. Senza registrazione, senza tracciamento e senza salvare ciò che crei.',
        'intro' => 'Crea codici QR per link, Wi-Fi e contatti e genera password casuali sicure direttamente sul tuo dispositivo.',
        'content' => [
            ['heading' => 'Codici QR e password creati sul tuo dispositivo', 'body' => 'Il Generatore di codici QR crea codici per link, testo, reti Wi-Fi, email, numeri di telefono e SMS, con colori e dimensioni a scelta, in PNG per lo schermo o SVG per la stampa. Il Generatore di password crea password casuali da 4 a 128 caratteri con il generatore di numeri casuali crittograficamente sicuro del tuo browser.'],
            ['heading' => 'Perché questi codici e password non scadono?', 'body' => 'I codici QR sono statici: i dati sono nel codice stesso e non dietro un link di reindirizzamento, quindi funzionano per sempre e non dipendono da questo sito. Le password vengono generate sul tuo dispositivo e non vengono mai inviate, quindi non ne esiste alcuna copia su un server.'],
        ],
        'faqs' => [
            ['q' => 'Come creo un codice QR per il Wi-Fi?', 'a' => 'Scegli Wi-Fi nel Generatore di codici QR, inserisci nome della rete, password e tipo di sicurezza, poi scarica il codice. Gli ospiti lo inquadrano e si collegano senza digitare la password.'],
            ['q' => 'Quanto deve essere lunga una password?', 'a' => 'Almeno 15 caratteri, il minimo delle attuali linee guida del NIST, e 16 o più per gli account importanti.'],
            ['q' => 'Posso usare i codici QR a fini commerciali?', 'a' => 'Sì. I codici che crei si possono usare gratis su confezioni, menu, volantini e biglietti da visita.'],
        ],
    ],
    'games' => [
        'name' => 'Fortuna e giochi',
        'short' => 'Giochi',
        'subtitle' => 'Dadi, monete e ruote',
        'title' => 'Lancio di dadi, testa o croce e ruota della fortuna gratis',
        'description' => 'Lancio di dadi, testa o croce, ruota per estrazioni e numeri casuali gratis. Risultati equi e casuali con animazioni. Senza registrazione.',
        'intro' => 'Lancia dadi, fai testa o croce, gira una ruota o estrai numeri a caso. Ogni risultato viene generato in modo equo sul tuo dispositivo con casualità sicura.',
        'content' => [
            ['heading' => 'Quale strumento del caso mi serve?', 'body' => 'Usa il Lancio dei dadi per giochi da tavolo e di ruolo (dal D4 al D100, fino a 10 dadi insieme). Fai testa o croce per decidere al volo tra sì e no o chi inizia. Gira la ruota per estrarre un nome o una scelta da una lista di massimo 100 voci, e usa il Generatore di numeri casuali per lotterie, estrazioni e campionamenti, con o senza ripetizioni.'],
            ['heading' => 'I risultati sono davvero casuali?', 'body' => 'Tutti gli strumenti usano la Web Crypto API del tuo browser, una fonte di casualità crittograficamente sicura, quindi ogni esito è ugualmente probabile e imprevedibile. Il risultato viene deciso prima che parta l’animazione, che quindi non può influenzarlo.'],
        ],
        'faqs' => [
            ['q' => 'Come estraggo un nome a caso da una lista?', 'a' => 'Incolla i nomi nella ruota, uno per riga, e premi Gira. Spunta “Rimuovi il vincitore dopo ogni giro” per estrarre più nomi senza ripetizioni.'],
            ['q' => 'Come genero numeri per la lotteria?', 'a' => 'Usa il Generatore di numeri casuali con la preimpostazione “Lotteria 6 su 49”, oppure scegli intervallo e quantità con “Senza ripetizioni” spuntato.'],
            ['q' => 'Il testa o croce online è equo?', 'a' => 'Sì. Ogni lancio ha esattamente il 50% di probabilità di testa e il 50% di croce, grazie a una casualità sicura.'],
        ],
    ],
    'time-tools' => [
        'name' => 'Strumenti per il tempo',
        'short' => 'Tempo',
        'subtitle' => 'Timer, cronometro e sonno',
        'title' => 'Strumenti per il tempo gratuiti: cronometro e timer',
        'description' => 'Un cronometro preciso con giri e un timer con allarme e preimpostazioni rapide. Gratis, senza registrazione e sempre esatti anche con la scheda in background.',
        'intro' => 'Un cronometro preciso con giri e un timer con allarme. Entrambi restano esatti anche quando la scheda è in background.',
        'content' => [
            ['heading' => 'Cronometro, timer o calcolatore del sonno?', 'body' => 'Usa il Cronometro per misurare quanto dura qualcosa, con giri e tempi intermedi al centesimo di secondo. Usa il Timer quando sai quanto tempo hai, per cucinare, studiare o fare un Pomodoro da 25 minuti, e vuoi un allarme alla fine. Usa il Calcolatore del sonno per pianificare l’ora di andare a letto o di svegliarti in base ai cicli da 90 minuti, o per contare quante ore hai dormito.'],
            ['heading' => 'Restano precisi in una scheda in background?', 'body' => 'Sì. I browser rallentano le schede in background, quindi questi strumenti calcolano il tempo da un momento fisso di inizio o di fine con l’orologio ad alta risoluzione del dispositivo, invece di contare gli scatti. La lettura è corretta quando torni, e il Timer mostra il tempo rimasto anche nel titolo della scheda.'],
        ],
        'faqs' => [
            ['q' => 'Posso lasciare il timer attivo mentre uso altre schede?', 'a' => 'Sì. Tieni aperta la scheda: il tempo resta esatto e l’allarme suona comunque alla fine del conto alla rovescia.'],
            ['q' => 'Posso registrare i tempi sul giro?', 'a' => 'Sì. Premi Giro (o L) nel Cronometro. Ogni giro mostra il proprio tempo e il totale, e puoi copiarli tutti insieme.'],
            ['q' => 'Quante ore di sonno servono a un adulto?', 'a' => 'La National Sleep Foundation raccomanda da 7 a 9 ore a notte per gli adulti tra i 18 e i 64 anni.'],
        ],
    ],
    'developer-tools' => [
        'name' => 'Strumenti per sviluppatori',
        'short' => 'Dev',
        'subtitle' => 'Formatta, codifica e analizza',
        'title' => 'Strumenti per sviluppatori: JSON, Base64 e IP',
        'description' => 'Utility online gratuite per sviluppatori: formatta e convalida JSON, codifica e decodifica Base64 e controlla subito il tuo indirizzo IP pubblico.',
        'intro' => 'Utility quotidiane per sviluppatori e tecnici: formattare JSON, codificare Base64 e controllare il proprio indirizzo IP.',
        'content' => [
            ['heading' => 'Utility quotidiane per sviluppatori', 'body' => 'Il Formattatore JSON abbellisce, convalida e minifica il JSON e indica la riga e la colonna esatte di ogni errore. Il codificatore e decodificatore Base64 converte testo o file da e verso Base64, compresa la variante sicura per URL e le data URL per HTML e CSS. Qual è il mio IP mostra il tuo indirizzo IP pubblico, se è IPv4 o IPv6, e dettagli su browser e dispositivo.'],
            ['heading' => 'È sicuro incollare qui dati di un’API?', 'body' => 'Sì. Gli strumenti JSON e Base64 funzionano interamente nel tuo browser, quindi risposte di API, token e file di configurazione non vengono mai inviati a un server. L’unica richiesta del sito è quella che serve a Qual è il mio IP per leggere il tuo indirizzo pubblico, che ti viene mostrato e non viene salvato.'],
        ],
        'faqs' => [
            ['q' => 'Perché il mio JSON non è valido?', 'a' => 'Le cause più comuni sono virgole finali, apici singoli al posto delle virgolette doppie, chiavi senza virgolette e commenti. Il JSON standard non ne ammette nessuno.'],
            ['q' => 'Il Base64 è una crittografia?', 'a' => 'No. Il Base64 è una codifica che chiunque può invertire, quindi non usarlo mai per proteggere password o segreti.'],
            ['q' => 'Che differenza c’è tra IPv4 e IPv6?', 'a' => 'Gli indirizzi IPv4 sono come 203.0.113.42 e sono esauriti nella maggior parte delle regioni. Gli IPv6, come 2001:db8::1, sono nati per offrire moltissimi più indirizzi.'],
        ],
    ],
];
