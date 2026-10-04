<?php

return [

    'word-counter' => [
        'name' => 'Wortzähler',
        'title' => 'Wortzähler: Wörter und Zeichen online kostenlos zählen',
        'description' => 'Kostenloser Online-Wortzähler. Zähle Wörter, Zeichen, Sätze und Absätze sofort und sieh dir Lesezeit und Keyword-Dichte an. Ohne Anmeldung.',
        'h1' => 'Wortzähler',
        'tagline' => 'Zähle Wörter, Zeichen, Sätze und Lesezeit sofort.',
        'keywords' => ['wortzähler', 'zeichenzähler', 'wörter zählen', 'wörter zählen online', 'lesezeit berechnen'],
        'intro' => 'Ein Wortzähler ist ein Tool, das die Wörter, Zeichen, Sätze und Absätze eines Textes zählt. Füge deinen Text unten ein oder tippe ihn, um Wörter, Zeichen, Sätze und Absätze beim Schreiben zu zählen. Der Wortzähler zeigt außerdem die geschätzte Lese- und Sprechzeit sowie deine häufigsten Schlüsselwörter – praktisch für Aufsätze, Blogartikel, Social-Media-Posts und SEO-Meta-Beschreibungen.',
        'steps' => [
            'Tippe deinen Text in das Feld oder füge ihn ein.',
            'Sieh zu, wie sich die Zahl der Wörter, Zeichen, Sätze und Absätze live aktualisiert.',
            'Prüfe Lesezeit, Sprechzeit und Keyword-Dichte unter dem Feld.',
            'Nutze Kopieren oder Leeren, wenn du fertig bist.',
        ],
        'features' => [
            'Live-Zählung von Wörtern, Zeichen, Sätzen und Absätzen',
            'Zeichen mit und ohne Leerzeichen',
            'Lesezeit (238 Wörter/Min.) und Sprechzeit (150 Wörter/Min.)',
            'Keyword-Dichte, um Wortwiederholungen zu vermeiden',
            'Funktioniert nach dem Laden offline – dein Text wird nie hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Warum die Wortzahl wichtig ist',
                'body' => 'Schulen, Hochschulen und Verlage setzen oft strenge Wortgrenzen, und soziale Netzwerke begrenzen die Zeichenzahl pro Beitrag. Suchmaschinen zeigen meist etwa 155-160 Zeichen einer Meta-Beschreibung an, und ein Title-Tag sollte unter etwa 60 Zeichen bleiben. Wenn du die genaue Zahl kennst, triffst du diese Vorgaben ohne Raten.',
            ],
            [
                'heading' => 'Wie Wörter gezählt werden',
                'body' => 'Ein Wort ist jede Gruppe von Buchstaben oder Ziffern, die durch Leerzeichen oder Zeilenumbrüche getrennt ist. Satzzeichen allein zählen nicht als Wort. Sätze werden anhand der Schlusszeichen (. ! ?) gezählt, Absätze anhand von Leerzeilen – die Zahlen entsprechen also dem, was du von Textverarbeitungen wie Microsoft Word und Google Docs kennst.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist dieser Wortzähler kostenlos?', 'a' => 'Ja. Der Wortzähler ist völlig kostenlos, ohne Anmeldung und ohne Begrenzung der Textmenge.'],
            ['q' => 'Wird mein Text gespeichert oder hochgeladen?', 'a' => 'Nein. Die Zählung findet vollständig in deinem Browser statt. Dein Text wird nie an unseren Server gesendet oder irgendwo gespeichert.'],
            ['q' => 'Wie wird die Lesezeit berechnet?', 'a' => 'Die Lesezeit basiert auf einer durchschnittlichen stillen Lesegeschwindigkeit Erwachsener von 238 Wörtern pro Minute. Die Sprechzeit nutzt 150 Wörter pro Minute, ein typisches Tempo für Präsentationen.'],
            ['q' => 'Wie viele Wörter hat ein 5-seitiger Aufsatz?', 'a' => 'Mit doppeltem Zeilenabstand und 12-Punkt-Schrift hat eine Seite etwa 250-300 Wörter, ein 5-seitiger Aufsatz also etwa 1.250-1.500 Wörter.'],
            ['q' => 'Zählt er Zeichen mit Leerzeichen?', 'a' => 'Ja. Du bekommst die Zeichen mit und ohne Leerzeichen – letztere meinen die meisten Zeichenbegrenzungen.'],
        ],
    ],

    'case-converter' => [
        'name' => 'Groß-/Kleinschreibung umwandeln',
        'title' => 'Groß-/Kleinschreibung umwandeln: Groß, klein, Titel',
        'description' => 'Wandle Text in GROSSBUCHSTABEN, kleinbuchstaben, Titelschreibung, Satzanfang groß, camelCase, snake_case und mehr um. Kostenlos, sofort und privat.',
        'h1' => 'Groß-/Kleinschreibung umwandeln',
        'tagline' => 'Ändere Text mit einem Klick in Groß-, Klein-, Titel-, Satz-, Camel- oder Snake-Schreibweise.',
        'keywords' => ['groß kleinschreibung umwandeln', 'großbuchstaben in kleinbuchstaben', 'titelschreibung', 'satzanfang groß', 'camelcase konverter'],
        'intro' => 'Ein Groß-/Kleinschreibungs-Umwandler ist ein Tool, das die Schreibweise eines Textes ändert, zum Beispiel von GROSSBUCHSTABEN in kleinbuchstaben. Versehentlich mit aktivierter Feststelltaste getippt oder brauchst du eine Überschrift in Titelschreibung? Füge deinen Text ein und klicke auf eine Schaltfläche, um ihn sofort umzuwandeln. Entwickler können außerdem zwischen camelCase, PascalCase, snake_case, kebab-case und CONSTANT_CASE wechseln.',
        'steps' => [
            'Füge deinen Text in das Feld ein.',
            'Klicke auf die gewünschte Schreibweise, zum Beispiel Titelschreibung oder kleinbuchstaben.',
            'Kopiere den umgewandelten Text oder lade ihn als .txt-Datei herunter.',
        ],
        'features' => [
            'GROSSBUCHSTABEN, kleinbuchstaben, Titelschreibung und Satzanfang groß',
            'camelCase, PascalCase, snake_case, kebab-case, CONSTANT_CASE',
            'aBwEcHsElNd und iNVERTIERT für lustige Posts',
            'Intelligente Titelschreibung, die kurze englische Wörter wie „and“ und „of“ kleinlässt',
            'Ergebnis kopieren oder herunterladen',
        ],
        'content' => [
            [
                'heading' => 'Titelschreibung oder Satzanfang groß',
                'body' => 'Die Titelschreibung schreibt die Hauptwörter einer Überschrift groß („The Quick Guide to SEO“), während kurze Wörter wie a, and, of und the klein bleiben, außer am Anfang. Bei „Satzanfang groß“ wird nur das erste Wort jedes Satzes großgeschrieben („The quick guide to SEO“), was viele moderne Websites wegen der Lesbarkeit bevorzugen. Im Deutschen bleiben Substantive natürlich immer großgeschrieben – prüfe das Ergebnis also kurz.',
            ],
            [
                'heading' => 'Schreibweisen in der Programmierung',
                'body' => 'camelCase ist bei JavaScript-Variablen üblich, PascalCase bei Klassennamen, snake_case in Python und bei Datenbankspalten, kebab-case bei URLs und CSS-Klassen und CONSTANT_CASE bei Konstanten und Umgebungsvariablen.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich Großbuchstaben in Kleinbuchstaben um?', 'a' => 'Füge deinen Text ein und klicke auf „kleinbuchstaben“. Jeder Buchstabe wird sofort umgewandelt, und du kannst das Ergebnis mit einem Klick kopieren.'],
            ['q' => 'Schreibt die Titelschreibung jedes Wort groß?', 'a' => 'Nein. Sie folgt gängigen englischen Stilregeln und lässt kurze Wörter (a, an, the, and, but, or, of, in, on, at, to, for) klein, außer sie stehen am Anfang oder Ende.'],
            ['q' => 'Gibt es eine Längenbegrenzung?', 'a' => 'Praktisch nicht. Die Umwandlung findet in deinem Browser statt, daher werden auch lange Dokumente sofort umgewandelt.'],
            ['q' => 'Funktioniert es mit Umlauten und Akzenten?', 'a' => 'Ja. Umlaute und Buchstaben mit Akzent wie ä, ö, ü, é und ñ werden korrekt umgewandelt.'],
        ],
    ],

    'password-generator' => [
        'name' => 'Passwort-Generator',
        'title' => 'Passwort-Generator: sichere Zufallspasswörter kostenlos',
        'description' => 'Erzeuge sichere Zufallspasswörter mit eigener Länge, Sonderzeichen und Ziffern. Sicher auf deinem Gerät erstellt und nie übertragen. Kostenlos und sofort.',
        'h1' => 'Sicherer Passwort-Generator',
        'tagline' => 'Erstelle sichere Zufallspasswörter mit einem Klick – direkt auf deinem Gerät.',
        'keywords' => ['passwort generator', 'sicheres passwort generator', 'zufallspasswort generator', 'sicheres passwort'],
        'intro' => 'Ein Passwort-Generator ist ein Tool, das aus den gewählten Zeichen zufällige, schwer zu erratende Passwörter erzeugt. Erstelle ein starkes Zufallspasswort, das praktisch nicht zu erraten ist. Wähle die Länge und die enthaltenen Zeichen – der Generator nutzt den kryptografisch sicheren Zufallszahlengenerator deines Browsers. Passwörter werden nie an unseren Server gesendet.',
        'steps' => [
            'Wähle eine Passwortlänge (16 oder mehr wird empfohlen).',
            'Hake die gewünschten Zeichenarten an: Großbuchstaben, Kleinbuchstaben, Ziffern und Sonderzeichen.',
            'Klicke auf Generieren und dann auf Kopieren, um dein neues Passwort zu verwenden.',
        ],
        'features' => [
            'Länge von 4 bis 128 Zeichen',
            'Großbuchstaben, Kleinbuchstaben, Ziffern und Sonderzeichen',
            'Option, ähnlich aussehende Zeichen auszuschließen (l, 1, I, O, 0)',
            'Stärkeanzeige auf Basis der echten Entropie',
            'Nutzt crypto.getRandomValues – sicher und unverzerrt',
        ],
        'content' => [
            [
                'heading' => 'Was macht ein Passwort sicher?',
                'body' => 'Am wichtigsten ist die Länge. Jedes zusätzliche Zeichen vervielfacht die Zahl der möglichen Kombinationen. Ein 16-stelliges Passwort mit Groß- und Kleinbuchstaben, Ziffern und Sonderzeichen hat über 100 Bit Entropie – mit heutiger Hardware würde ein Brute-Force-Angriff Milliarden Jahre dauern.',
            ],
            [
                'heading' => 'Tipps für sichere Passwörter',
                'body' => 'Verwende für jedes Konto ein anderes Passwort, speichere sie in einem Passwort-Manager und aktiviere die Zwei-Faktor-Authentifizierung, wo immer sie angeboten wird. Verwende nie ein Passwort erneut, das in einem Datenleck aufgetaucht ist.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist dieser Passwort-Generator sicher?', 'a' => 'Ja. Passwörter werden in deinem Browser mit der Web Crypto API erzeugt. Nichts wird an unseren Server gesendet, protokolliert oder gespeichert.'],
            ['q' => 'Wie lang sollte mein Passwort sein?', 'a' => 'Mindestens 15 Zeichen, so verlangen es die aktuellen NIST-Richtlinien (SP 800-63B), für wichtige Konten wie E-Mail und Online-Banking 16 oder mehr.'],
            ['q' => 'Was bewirkt „Ähnliche ausschließen“?', 'a' => 'Es entfernt Zeichen, die sich ähneln, wie l, 1, I, O und 0, damit das Passwort leichter zu lesen und von Hand einzutippen ist.'],
            ['q' => 'Was ist Passwort-Entropie?', 'a' => 'Die Entropie misst in Bit, wie unvorhersehbar ein Passwort ist. Jedes zusätzliche Bit verdoppelt die Zahl der Versuche, die ein Angreifer braucht. Ab 80 Bit ist es stark, ab 100 Bit ausgezeichnet.'],
        ],
        'table' => [
            'caption' => 'Passwortlänge und Stärke (Entropie in Bit)',
            'headers' => ['Länge', 'Buchstaben und Ziffern (62 Zeichen)', 'Buchstaben, Ziffern und Sonderzeichen (89 Zeichen)'],
            'rows' => [
                ['8', '48', '52'],
                ['12', '71', '78'],
                ['16', '95', '104'],
                ['20', '119', '130'],
                ['32', '191', '207'],
            ],
        ],
    ],

    'qr-code-generator' => [
        'name' => 'QR-Code-Generator',
        'title' => 'QR-Code-Generator: kostenlose QR-Codes für URL und WLAN',
        'description' => 'Erstelle kostenlose QR-Codes für Links, Text, WLAN, E-Mail, Telefon und SMS. Eigene Farben und Größen, PNG oder SVG. Laufen nie ab.',
        'h1' => 'Kostenloser QR-Code-Generator',
        'tagline' => 'Erstelle QR-Codes für Links, WLAN, E-Mail, Telefon und SMS. Download als PNG oder SVG.',
        'keywords' => ['qr code generator', 'qr code kostenlos erstellen', 'wlan qr code', 'qr code erstellen', 'qr code für url'],
        'intro' => 'Ein QR-Code-Generator ist ein Tool, das einen Link, einen Text oder WLAN-Zugangsdaten in einen quadratischen Code verwandelt, den Handykameras scannen können. Erstelle in Sekunden einen QR-Code für einen Website-Link, Text, ein WLAN, eine E-Mail, eine Telefonnummer oder eine SMS. Wähle Farben und Größe und lade ein hochwertiges PNG für Bildschirme oder ein SVG für den Druck herunter. Es sind statische QR-Codes – sie funktionieren für immer und laufen nie ab.',
        'steps' => [
            'Wähle den QR-Code-Typ: URL, Text, WLAN, E-Mail, Telefon oder SMS.',
            'Fülle die Angaben aus. Die Vorschau aktualisiert sich beim Tippen.',
            'Passe nach Wunsch Größe, Farben und Fehlerkorrektur an.',
            'Lade ihn als PNG oder SVG herunter und teste ihn mit der Handykamera.',
        ],
        'features' => [
            'QR-Codes für URL, Text, WLAN, E-Mail, Telefon und SMS',
            'Eigene Vorder- und Hintergrundfarben',
            'Größen von 128 px bis 1024 px',
            'Fehlerkorrekturstufen L, M, Q und H',
            'Download als PNG und SVG – kostenlos auch für kommerzielle Nutzung',
            'Statische Codes, die nie ablaufen, ohne Tracking',
        ],
        'content' => [
            [
                'heading' => 'So erstellst du einen WLAN-QR-Code',
                'body' => 'Wähle den Typ WLAN und gib Netzwerknamen (SSID), Passwort und Sicherheitstyp ein. Gäste können den Code dann mit der Handykamera scannen und sich ohne Passworteingabe verbinden – ideal für Zuhause, Cafés und Büros.',
            ],
            [
                'heading' => 'Tipps für QR-Codes, die immer funktionieren',
                'body' => 'Achte auf starken Kontrast mit dunklem Code auf hellem Hintergrund, lass den Ruherand um den Code frei und drucke ihn mindestens 2 x 2 cm groß. Wähle eine höhere Fehlerkorrektur, wenn der Code zerkratzt oder schmutzig werden könnte.',
            ],
        ],
        'faqs' => [
            ['q' => 'Laufen diese QR-Codes ab?', 'a' => 'Nein. Es sind statische QR-Codes, in denen deine Daten direkt kodiert sind. Sie funktionieren für immer und hängen nicht von unserer Website ab.'],
            ['q' => 'Darf ich die QR-Codes kommerziell nutzen?', 'a' => 'Ja. Du kannst die erstellten QR-Codes kostenlos auf Flyern, Verpackungen, Speisekarten und Visitenkarten verwenden.'],
            ['q' => 'Soll ich PNG oder SVG herunterladen?', 'a' => 'PNG eignet sich am besten für Websites und Dokumente. SVG ist ein Vektorformat, das in jeder Größe scharf bleibt – ideal für den Druck.'],
            ['q' => 'Was ist Fehlerkorrektur?', 'a' => 'Dank Fehlerkorrektur lässt sich ein QR-Code auch dann noch scannen, wenn ein Teil beschädigt ist. Stufe L stellt etwa 7 % des Codes wieder her, Stufe H etwa 30 %, höhere Stufen machen den Code aber dichter.'],
            ['q' => 'Warum lässt sich mein QR-Code nicht scannen?', 'a' => 'Meist sind die Farben zu ähnlich oder vertauscht (heller Code auf dunklem Grund). Verwende einen dunklen Code auf hellem Hintergrund mit gutem Kontrast.'],
        ],
        'table' => [
            'caption' => 'Fehlerkorrekturstufen von QR-Codes',
            'headers' => ['Stufe', 'Stellt bis zu wieder her', 'Geeignet für'],
            'rows' => [
                ['L', '7 %', 'Saubere Bildschirme und Codes mit vielen Daten'],
                ['M', '15 %', 'Die meisten Anwendungen (die häufigste Wahl)'],
                ['Q', '25 %', 'Gedruckte Codes, die schmutzig werden können'],
                ['H', '30 %', 'Raue Umgebungen, etwa Etiketten in Fabriken'],
            ],
        ],
    ],

    'image-compressor' => [
        'name' => 'Bild komprimieren',
        'title' => 'Bild komprimieren: JPG, PNG und WebP online verkleinern',
        'description' => 'Komprimiere JPG-, PNG- und WebP-Bilder kostenlos. Verkleinere Fotos auf 100 KB ohne sichtbaren Qualitätsverlust. Nichts verlässt dein Gerät.',
        'h1' => 'Bild komprimieren',
        'tagline' => 'Verkleinere JPG-, PNG- und WebP-Dateien – sogar auf eine exakte Größe wie 100 KB.',
        'keywords' => ['bild komprimieren', 'bild verkleinern', 'bild auf 100kb komprimieren', 'bildgröße reduzieren', 'jpg komprimieren'],
        'intro' => 'Ein Bildkomprimierer ist ein Tool, das Bilddateien verkleinert, ohne dass sie sichtbar schlechter aussehen. Mach deine Bilder kleiner, ohne sichtbar an Qualität zu verlieren. Lege eine oder mehrere JPG-, PNG- oder WebP-Dateien ab, wähle eine Qualitätsstufe oder eine Zielgröße wie 100 KB und lade die komprimierten Bilder herunter. Die Komprimierung passiert in deinem Browser, deine Fotos werden also nie hochgeladen.',
        'steps' => [
            'Bilder per Drag & Drop ablegen oder zum Auswählen klicken (JPG, PNG oder WebP).',
            'Eine Qualitätsstufe wählen oder eine Zielgröße wie 100 KB festlegen.',
            'Optional ein Ausgabeformat und eine maximale Breite wählen.',
            'Jedes Bild einzeln oder alle als ZIP herunterladen.',
        ],
        'features' => [
            'Bis zu 30 Bilder auf einmal komprimieren',
            'Zielgrößen-Modus, z. B. „auf 100 KB komprimieren“',
            'Umwandlung in WebP für die größte Ersparnis',
            'Optionale maximale Breite, um riesige Fotos zu verkleinern',
            'Dateigröße vorher und nachher mit eingesparten %',
            '100 % privat – im Browser verarbeitet',
        ],
        'content' => [
            [
                'heading' => 'Warum Bilder komprimieren?',
                'body' => 'Große Bilder sind der häufigste Grund für langsame Webseiten, und die Ladegeschwindigkeit ist ein Google-Rankingfaktor. Kleinere Bilder lassen sich außerdem schneller in Formulare und Jobportale hochladen, die Grenzen wie 100 KB, 200 KB oder 1 MB setzen.',
            ],
            [
                'heading' => 'Welches Format soll ich wählen?',
                'body' => 'JPG eignet sich am besten für Fotos. PNG erhält Transparenz und scharfe Kanten für Logos und Screenshots, erzeugt aber große Dateien. WebP liefert die kleinsten Dateien für Fotos und Grafiken und wird von allen modernen Browsern unterstützt.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie komprimiere ich ein Bild auf 100 KB?', 'a' => 'Wähle „Zielgröße“, gib 100 ein und klicke auf Komprimieren. Das Tool findet die beste Qualität unter 100 KB und verkleinert die Abmessungen nur, wenn es nötig ist.'],
            ['q' => 'Werden meine Bilder auf einen Server hochgeladen?', 'a' => 'Nein. Die Bilder werden in deinem Browser mit der Canvas-API komprimiert. Sie verlassen nie dein Gerät.'],
            ['q' => 'Verringert die Komprimierung die Qualität?', 'a' => 'Bei der Standardqualität (75 %) sehen die meisten keinen Unterschied, während die Dateigröße oft um 50-80 % sinkt.'],
            ['q' => 'Warum ist mein PNG kaum kleiner geworden?', 'a' => 'PNG ist ein verlustfreies Format. Für große Einsparungen wähle WebP oder JPG als Ausgabeformat. Nimm WebP, wenn die Transparenz erhalten bleiben soll.'],
            ['q' => 'Gibt es eine Größenbeschränkung?', 'a' => 'Jedes Bild darf bis zu 50 MB groß sein. Sehr große Fotos können auf älteren Smartphones ein paar Sekunden dauern.'],
        ],
        'table' => [
            'caption' => 'Welches Bildformat passt',
            'headers' => ['Format', 'Am besten für', 'Transparenz'],
            'rows' => [
                ['JPG', 'Fotos', 'Nein'],
                ['PNG', 'Logos, Screenshots, scharfe Grafiken', 'Ja'],
                ['WebP', 'Websites (kleinste Dateien für Fotos und Grafiken)', 'Ja'],
            ],
        ],
    ],

    'image-resizer' => [
        'name' => 'Bildgröße ändern',
        'title' => 'Bildgröße ändern: JPG, PNG und WebP skalieren und umwandeln',
        'description' => 'Ändere die Bildgröße auf exakte Pixel oder prozentual und wandle zwischen JPG, PNG und WebP um. Kostenloses Online-Tool, bei dem deine Fotos privat bleiben.',
        'h1' => 'Bildgröße ändern & umwandeln',
        'tagline' => 'Skaliere auf exakte Pixel oder prozentual und wandle JPG, PNG und WebP um.',
        'keywords' => ['bildgröße ändern', 'bild skalieren', 'png in jpg', 'jpg in png', 'webp in jpg', 'bild konverter'],
        'intro' => 'Ein Tool zum Ändern der Bildgröße passt Breite und Höhe eines Bildes an, und ein Konverter ändert sein Dateiformat. Bringe ein Foto auf die exakten Maße für soziale Netzwerke, ein Passformular oder deine Website, oder skaliere es prozentual. Du kannst auch das Format umwandeln, zum Beispiel PNG in JPG oder WebP in PNG. Alles passiert in deinem Browser.',
        'steps' => [
            'Ein Bild auswählen oder ablegen (JPG, PNG, WebP, GIF oder BMP).',
            'Neue Breite und Höhe eingeben oder einen Prozentwert wählen.',
            'Ausgabeformat und Qualität wählen.',
            'Auf Herunterladen klicken, um das geänderte Bild zu speichern.',
        ],
        'features' => [
            'Größe nach Pixeln oder Prozent ändern',
            'Seitenverhältnis sperren, damit nichts verzerrt',
            'Umwandlung zwischen JPG, PNG und WebP',
            'Qualitätsregler für JPG und WebP',
            'Live-Vorschau mit neuer Dateigröße',
        ],
        'content' => [
            [
                'heading' => 'Übliche Bildgrößen',
                'body' => 'Instagram-Posts funktionieren gut mit 1080 x 1080 Pixeln, geteilte Bilder auf Facebook und LinkedIn mit 1200 x 630, YouTube-Thumbnails mit 1280 x 720, und große Website-Bilder brauchen meist nicht mehr als 1920 Pixel Breite.',
            ],
            [
                'heading' => 'PNG in JPG umwandeln',
                'body' => 'JPG unterstützt keine Transparenz, deshalb werden transparente Bereiche beim Umwandeln von PNG in JPG weiß gefüllt. Wenn die Transparenz erhalten bleiben soll, wähle PNG oder WebP als Ausgabeformat.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie ändere ich die Bildgröße, ohne es zu verzerren?', 'a' => 'Lass „Seitenverhältnis beibehalten“ angehakt. Wenn du die Breite änderst, passt sich die Höhe automatisch an die ursprünglichen Proportionen an.'],
            ['q' => 'Kann ich WebP in JPG umwandeln?', 'a' => 'Ja. Öffne dein WebP-Bild, wähle JPG als Ausgabeformat und lade es herunter.'],
            ['q' => 'Verschlechtert das Skalieren die Qualität?', 'a' => 'Beim Verkleinern bleibt das Bild scharf. Deutlich größer als das Original kann es unscharf wirken, weil keine neuen Details entstehen können.'],
            ['q' => 'Wie groß darf das Bild maximal sein?', 'a' => 'Ausgabebilder dürfen bis zu 10.000 Pixel pro Seite haben – das können alle modernen Browser verarbeiten.'],
        ],
        'table' => [
            'caption' => 'Übliche Bildgrößen',
            'headers' => ['Verwendung', 'Größe (Pixel)'],
            'rows' => [
                ['Quadratischer Instagram-Post', '1080 × 1080'],
                ['Geteiltes Bild auf Facebook und LinkedIn', '1200 × 630'],
                ['YouTube-Thumbnail', '1280 × 720'],
                ['Bild in voller Website-Breite', 'bis 1920 breit'],
            ],
        ],
    ],

    'jpg-to-pdf' => [
        'name' => 'JPG zu PDF',
        'title' => 'JPG zu PDF: Bilder online kostenlos in PDF umwandeln',
        'description' => 'Wandle JPG-, PNG- oder WebP-Bilder kostenlos in PDF um. Fotos anordnen, Seitengröße, Ausrichtung und Ränder wählen. Kein Upload, kein Wasserzeichen.',
        'h1' => 'JPG zu PDF',
        'tagline' => 'Kombiniere JPG-, PNG- und WebP-Bilder in einer PDF-Datei.',
        'keywords' => ['jpg zu pdf', 'jpg in pdf umwandeln', 'bild zu pdf', 'jpg zu pdf online', 'jpg pdf konverter'],
        'intro' => 'Ein JPG-zu-PDF-Konverter wandelt JPG-, PNG- oder WebP-Bilder in ein einziges PDF-Dokument um. Füge mehrere Fotos hinzu, ordne sie neu an und wähle Seitengröße, Ausrichtung und Ränder, bevor du sie zu einem Dokument zusammenfügst. Dieser JPG-zu-PDF-Konverter läuft vollständig auf deinem Gerät, sodass deine Bilder nie auf einen Server hochgeladen werden.',
        'steps' => [
            'Ein oder mehrere JPG-, PNG- oder WebP-Bilder per Ablegen oder Durchsuchen hinzufügen.',
            'Die Bilder bei Bedarf mit den Pfeilen nach oben und unten neu anordnen.',
            'Seitengröße, Ausrichtung und Rand wählen.',
            'Auf In PDF umwandeln klicken und die Datei herunterladen.',
        ],
        'features' => [
            'JPG-, PNG- und WebP-Bilder in einem PDF kombinieren',
            'Bilder vor dem Umwandeln neu anordnen oder entfernen',
            'Seitengrößen A4, Letter oder An Bild anpassen',
            'Automatische oder manuelle Seitenausrichtung',
            'Anpassbare Ränder um jedes Foto',
            'Privat – Bilder verlassen nie dein Gerät',
        ],
        'content' => [
            [
                'heading' => 'Die richtige Seitengröße wählen',
                'body' => 'A4 und Letter fügen um Fotos, die nicht zur Seitenform passen, weißen Rand hinzu – das eignet sich für Dokumente und den Druck. An Bild anpassen richtet die PDF-Seite exakt an jedem Foto aus, sodass das ganze Bild ohne weiße Ränder sichtbar bleibt – praktisch, wenn du nur schnell eine PDF-Kopie eines Fotos brauchst.',
            ],
            [
                'heading' => 'Warum JPG in PDF umwandeln?',
                'body' => 'Eine einzelne PDF-Datei lässt sich leichter per E-Mail versenden, drucken und in Formulare hochladen als mehrere einzelne Bilddateien. Das Zusammenfügen von gescannten Seiten, Quittungen oder Fotos in einem PDF hält außerdem die richtige Reihenfolge ein und verhindert, dass sie durcheinandergeraten.',
            ],
        ],
        'faqs' => [
            ['q' => 'Kann ich mehrere Bilder in einer PDF-Datei kombinieren?', 'a' => 'Ja. Füge so viele JPG-, PNG- oder WebP-Bilder hinzu, wie du möchtest, bringe sie mit den Pfeilen in die gewünschte Reihenfolge, und sie werden zu einer einzigen PDF-Datei kombiniert.'],
            ['q' => 'Fügt dieser JPG-zu-PDF-Konverter ein Wasserzeichen hinzu?', 'a' => 'Nein. Das PDF enthält nur deine Bilder, ohne Wasserzeichen, Logo oder zusätzliche Seiten.'],
            ['q' => 'Kann ich auch PNG- und WebP-Bilder umwandeln, nicht nur JPG?', 'a' => 'Ja. JPG-, PNG- und WebP-Bilder werden alle unterstützt und können im selben PDF gemischt werden.'],
            ['q' => 'Was bewirkt die Randeinstellung?', 'a' => 'Sie fügt Leerraum um jedes Bild auf der Seite hinzu. Wähle Kein, damit das Bild bis an den Rand reicht, oder einen größeren Rand für einen dokumentähnlicheren Look.'],
            ['q' => 'Wird die Qualität meiner Bilder verringert?', 'a' => 'JPG- und PNG-Bilder werden mit ihrer Originalqualität eingebettet. WebP-Bilder werden zuerst in PNG umgewandelt, wodurch die verlustfreie Qualität erhalten bleibt.'],
        ],
    ],

    'webp-to-png' => [
        'name' => 'WebP in PNG',
        'title' => 'WebP in PNG umwandeln: kostenlos und im Stapel',
        'description' => 'WebP kostenlos online in PNG umwandeln. Bis zu 30 Bilder auf einmal, Transparenz bleibt erhalten, Download als ZIP. Nichts verlässt dein Gerät.',
        'h1' => 'WebP in PNG umwandeln',
        'tagline' => 'Wandle WebP-Bilder in Sekunden in PNG um, mit erhaltener Transparenz.',
        'keywords' => ['webp in png', 'webp in png umwandeln', 'webp zu png', 'webp png konverter', 'webp to png'],
        'intro' => 'WebP ist ein von Google entwickeltes Bildformat mit kleinen Dateien, doch manche Apps, Programme und Formulare akzeptieren es noch nicht. Dieser WebP-zu-PNG-Konverter wandelt WebP-Bilder in PNG um, ein Format, das sich überall öffnen lässt, und behält transparente Hintergründe bei. Lege ein Bild oder einen ganzen Stapel ab und lade die Ergebnisse einzeln oder als ZIP herunter.',
        'steps' => [
            'Lege deine WebP-Bilder im Feld ab oder klicke zum Auswählen (bis zu 30 auf einmal).',
            'Jedes Bild wird sofort in deinem Browser in PNG umgewandelt.',
            'Klicke neben einem Bild auf Herunterladen oder auf Alle herunterladen (ZIP).',
            'Mit Alle entfernen fängst du mit neuen Bildern an.',
        ],
        'features' => [
            'Wandelt WebP in PNG um, Transparenz bleibt erhalten',
            'Stapelumwandlung von bis zu 30 Bildern',
            'ZIP-Download für mehrere Dateien',
            'Akzeptiert auch JPG, GIF und BMP',
            '100 % privat: nichts wird hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Warum WebP in PNG umwandeln?',
                'body' => 'Browser speichern viele Bilder aus dem Web als WebP, doch ältere Bildbearbeitungen, Office-Dokumente und manche Formulare akzeptieren nur PNG oder JPG. PNG ist verlustfrei und wird überall unterstützt, du erhältst also eine Datei, die sich überall ohne Detailverlust öffnen lässt. Dafür sind PNG-Dateien meist größer als WebP.',
            ],
            [
                'heading' => 'Verliert man beim Umwandeln von WebP in PNG Qualität?',
                'body' => 'Die Umwandlung selbst kostet keine Qualität, denn PNG ist verlustfrei: Jeder Pixel des WebP-Bildes wird exakt gespeichert. Wurde das ursprüngliche WebP verlustbehaftet komprimiert, bleibt dieser frühere Verlust bestehen, es kommt aber kein neuer hinzu.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich WebP in PNG um?', 'a' => 'Lege die WebP-Datei im Feld oben ab. Sie wird sofort in PNG umgewandelt und lässt sich mit einem Klick herunterladen.'],
            ['q' => 'Bleibt die Transparenz erhalten?', 'a' => 'Ja. PNG unterstützt Transparenz, transparente Bereiche des WebP-Bildes bleiben also auch nach der Umwandlung transparent.'],
            ['q' => 'Warum ist die PNG größer als die WebP-Datei?', 'a' => 'WebP komprimiert effizienter. PNG speichert jeden Pixel verlustfrei, deshalb braucht dasselbe Bild meist mehr Platz.'],
            ['q' => 'Werden meine Bilder hochgeladen?', 'a' => 'Nein. Die Umwandlung läuft in deinem Browser mit der Canvas-API, und deine Bilder verlassen nie dein Gerät.'],
        ],
    ],

    'png-to-jpg' => [
        'name' => 'PNG in JPG',
        'title' => 'PNG in JPG (JPEG) umwandeln: kostenlos online',
        'description' => 'PNG kostenlos online in JPG (JPEG) umwandeln. Bis zu 30 Bilder auf einmal, Qualität wählbar, Download als ZIP. Nichts wird auf einen Server geladen.',
        'h1' => 'PNG in JPG umwandeln',
        'tagline' => 'Wandle PNG-Bilder im Stapel in JPG (JPEG) um, mit einstellbarer Qualität.',
        'keywords' => ['png in jpg', 'png in jpg umwandeln', 'png zu jpg', 'png in jpeg', 'png to jpg'],
        'intro' => 'PNG ist ein verlustfreies Format, ideal für Grafiken, erzeugt aber große Dateien, während JPG (auch JPEG genannt) kleiner ist und fast überall akzeptiert wird. Dieser PNG-zu-JPG-Konverter wandelt ein oder mehrere PNG-Bilder in der gewünschten Qualität in JPG um. Transparente Bereiche werden weiß gefüllt, weil JPG keine Transparenz kennt.',
        'steps' => [
            'Lege deine PNG-Bilder im Feld ab oder klicke zum Auswählen (bis zu 30 auf einmal).',
            'Stell die Qualität ein, wenn du kleinere Dateien möchtest (ab 90 % sieht es gleich aus).',
            'Jedes Bild wird sofort in deinem Browser in JPG umgewandelt.',
            'Lade jede JPG einzeln oder alle zusammen als ZIP herunter.',
        ],
        'features' => [
            'Wandelt PNG im Stapel in JPG (JPEG) um',
            'JPG-Qualität einstellbar von 50 % bis 100 %',
            'Transparente Bereiche werden weiß gefüllt',
            'ZIP-Download für mehrere Dateien',
            'Privat: Die Bilder werden auf deinem Gerät verarbeitet',
        ],
        'content' => [
            [
                'heading' => 'Wann lohnt es sich, PNG in JPG umzuwandeln?',
                'body' => 'Wandle ein PNG in JPG um, wenn es ein Foto oder detailreiches Bild ist und die Datei für E-Mail, Website oder Formular zu groß ist, oder wenn eine Website JPG verlangt. Behalte PNG für Logos, Icons, Screenshots mit scharfem Text und alles, was einen transparenten Hintergrund braucht.',
            ],
            [
                'heading' => 'Sind JPG und JPEG dasselbe?',
                'body' => 'Ja. JPG und JPEG sind zwei Namen für dasselbe Format; die dreistellige Endung .jpg stammt aus älteren Windows-Versionen, die nur drei Zeichen erlaubten. Dateien aus diesem Konverter tragen die Endung .jpg, die jedes Gerät und jede Website akzeptiert.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich PNG in JPG um?', 'a' => 'Lege das PNG im Feld oben ab, dann wird es sofort in JPG umgewandelt. Klicke auf Herunterladen, um es zu speichern.'],
            ['q' => 'Was passiert mit einem transparenten Hintergrund?', 'a' => 'JPG kann keine Transparenz speichern, deshalb werden transparente Bereiche bei der Umwandlung weiß gefüllt.'],
            ['q' => 'Welche Qualität soll ich wählen?', 'a' => 'Die voreingestellten 92 % sehen aus wie das Original. Mit etwa 80 % werden die Dateien deutlich kleiner, mit kaum sichtbarem Unterschied.'],
            ['q' => 'Kann ich viele PNGs auf einmal umwandeln?', 'a' => 'Ja. Lege bis zu 30 Bilder gleichzeitig ab und lade alle zusammen als ZIP-Datei herunter.'],
        ],
    ],

    'jpg-to-png' => [
        'name' => 'JPG in PNG',
        'title' => 'JPG in PNG umwandeln (JPEG in PNG) kostenlos',
        'description' => 'JPG- oder JPEG-Bilder kostenlos online in PNG umwandeln. Verlustfrei, bis zu 30 Dateien auf einmal und Download als ZIP. Nichts verlässt dein Gerät.',
        'h1' => 'JPG in PNG umwandeln',
        'tagline' => 'Wandle JPG- und JPEG-Bilder im Stapel verlustfrei in PNG um.',
        'keywords' => ['jpg in png', 'jpeg in png', 'jpg in png umwandeln', 'jpg zu png', 'jpeg to png'],
        'intro' => 'PNG ist ein verlustfreies Format: Ein als PNG gespeichertes Bild lässt sich bearbeiten und erneut speichern, ohne unschärfer zu werden. Dieser JPEG-zu-PNG-Konverter wandelt JPG- und JPEG-Fotos in PNG-Dateien um, einzeln oder im Stapel von bis zu 30, direkt in deinem Browser.',
        'steps' => [
            'Lege deine JPG- oder JPEG-Bilder im Feld ab oder klicke zum Auswählen.',
            'Jedes Bild wird sofort in PNG umgewandelt.',
            'Klicke neben einem Bild auf Herunterladen oder auf Alle herunterladen (ZIP).',
            'Mit Alle entfernen wandelst du eine neue Auswahl um.',
        ],
        'features' => [
            'Wandelt JPG und JPEG verlustfrei in PNG um',
            'Stapelumwandlung von bis zu 30 Bildern',
            'ZIP-Download für mehrere Dateien',
            'Akzeptiert auch WebP, GIF und BMP',
            'Privat: nichts wird hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Warum JPG in PNG umwandeln?',
                'body' => 'Wandle in PNG um, wenn du ein Bild mehrmals bearbeiten, in ein Design einbauen möchtest oder eine Website oder App PNG verlangt. Jedes Speichern kostet ein JPG etwas Qualität, ein PNG nicht, deshalb ist es das sicherere Arbeitsformat.',
            ],
            [
                'heading' => 'Wird das Bild dadurch transparent oder schärfer?',
                'body' => 'Nein. Die Umwandlung lässt das Bild genau so, wie es ist: Ein JPG hat keine Transparenz, die übernommen werden könnte, und durch die JPG-Kompression verlorene Details lassen sich nicht zurückholen. Das PNG ist meist auch größer als das JPG, weil es jeden Pixel verlustfrei speichert.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich JPG in PNG um?', 'a' => 'Lege das JPG im Feld oben ab. Es wird sofort in PNG umgewandelt und lässt sich mit einem Klick herunterladen.'],
            ['q' => 'Gibt es einen Unterschied zwischen JPG und JPEG?', 'a' => 'Nein. Es sind zwei Namen für dasselbe Format, und beide werden gleich umgewandelt.'],
            ['q' => 'Warum ist die PNG-Datei größer?', 'a' => 'PNG ist verlustfrei und speichert jeden Pixel exakt. JPG spart Platz, indem es Details verwirft, deshalb sind seine Dateien kleiner.'],
            ['q' => 'Werden meine Fotos hochgeladen?', 'a' => 'Nein. Alles passiert in deinem Browser, und deine Fotos verlassen nie dein Gerät.'],
        ],
    ],

    'merge-pdf' => [
        'name' => 'PDF zusammenfügen',
        'title' => 'PDF zusammenfügen: PDF-Dateien online kostenlos kombinieren',
        'description' => 'Füge PDF-Dateien kostenlos zu einem Dokument zusammen. Reihenfolge ändern, ohne Wasserzeichen und Anmeldung. Nichts wird hochgeladen.',
        'h1' => 'PDF-Dateien zusammenfügen',
        'tagline' => 'Mehrere PDFs zu einer Datei kombinieren – ohne Wasserzeichen, ohne Upload.',
        'keywords' => ['pdf zusammenfügen', 'pdf kombinieren', 'pdf dateien zusammenführen', 'pdf merger', 'pdf zusammenfügen kostenlos online'],
        'intro' => 'PDFs zusammenfügen bedeutet, mehrere PDF-Dateien zu einem einzigen Dokument zu kombinieren. Kombiniere mehrere PDF-Dateien in der gewünschten Reihenfolge zu einem einzigen Dokument. Anders als bei vielen PDF-Websites werden deine Dateien in deinem Browser zusammengefügt – vertrauliche Dokumente berühren nie einen Server, und das Ergebnis hat kein Wasserzeichen.',
        'steps' => [
            'Zwei oder mehr PDF-Dateien hinzufügen, per Ablegen oder Durchsuchen.',
            'Mit den Pfeilen nach oben und unten in die richtige Reihenfolge bringen.',
            'Auf PDF zusammenfügen klicken.',
            'Das kombinierte PDF herunterladen.',
        ],
        'features' => [
            'Bis zu 50 PDF-Dateien auf einmal zusammenfügen',
            'Dateien vor dem Zusammenfügen sortieren oder entfernen',
            'Zeigt die Seitenzahl jeder Datei',
            'Kein Wasserzeichen und keine Seitenbegrenzung',
            'Privat – Dateien verlassen nie dein Gerät',
        ],
        'content' => [
            [
                'heading' => 'Warum PDFs zusammenfügen?',
                'body' => 'Viele Bewerbungsportale, Visumanträge und Hochschulportale akzeptieren nur eine einzige Datei. Wenn du Lebenslauf, Anschreiben und Zeugnisse zu einem PDF zusammenfügst, bleibt alles beisammen und in der richtigen Reihenfolge.',
            ],
            [
                'heading' => 'Passwortgeschützte PDFs',
                'body' => 'Verschlüsselte PDFs können erst zusammengefügt werden, wenn der Passwortschutz entfernt ist. Öffne die Datei mit dem Passwort in deinem PDF-Reader, speichere oder drucke eine ungeschützte Kopie und füge dann diese Kopie zusammen.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist es sicher, PDFs hier zusammenzufügen?', 'a' => 'Ja. Die Dateien werden lokal in deinem Browser mit JavaScript verarbeitet und nie hochgeladen, sie bleiben also vollständig privat.'],
            ['q' => 'Gibt es ein Wasserzeichen?', 'a' => 'Nein. Das zusammengefügte PDF hat kein Wasserzeichen, kein Logo und keine zusätzlichen Seiten.'],
            ['q' => 'Wie viele PDFs kann ich zusammenfügen?', 'a' => 'Bis zu 50 Dateien auf einmal. Die praktische Grenze hängt vom Speicher deines Geräts ab; die meisten Geräte schaffen problemlos einige hundert Seiten.'],
            ['q' => 'Bleiben Links und Lesezeichen erhalten?', 'a' => 'Seiteninhalte, Bilder und Text bleiben exakt erhalten. Manche interaktiven Funktionen wie Lesezeichen und Formularfelder werden eventuell nicht übernommen.'],
        ],
    ],

    'split-pdf' => [
        'name' => 'PDF teilen',
        'title' => 'PDF teilen: Seiten aus PDF online kostenlos extrahieren',
        'description' => 'Teile ein PDF in separate Dateien oder extrahiere Seiten kostenlos online. Bereiche wie 1-3, 5 wählen. Ohne Upload und ohne Wasserzeichen.',
        'h1' => 'PDF teilen & Seiten extrahieren',
        'tagline' => 'Seiten extrahieren oder ein PDF in separate Dateien teilen – privat in deinem Browser.',
        'keywords' => ['pdf teilen', 'seiten aus pdf extrahieren', 'pdf seiten trennen', 'pdf splitter', 'pdf online teilen'],
        'intro' => 'Ein PDF teilen bedeutet, Seiten aus einem Dokument herauszunehmen oder es in mehrere kleinere PDF-Dateien aufzuteilen. Hol dir nur die Seiten aus einem PDF, die du brauchst, oder teile es in separate Dateien. Gib Seitenbereiche wie 1-3, 5, 8-10 ein oder mache aus jeder Seite ein eigenes PDF. Die Verarbeitung findet vollständig in deinem Browser statt.',
        'steps' => [
            'Das PDF auswählen, das du teilen möchtest.',
            'Einen Modus wählen: Seiten in ein PDF extrahieren, nach Bereichen teilen oder jede Seite trennen.',
            'Seitenbereiche eingeben, zum Beispiel 1-3, 5, 8-10.',
            'Auf PDF teilen klicken und das Ergebnis herunterladen (mehrere Dateien kommen als ZIP).',
        ],
        'features' => [
            'Ausgewählte Seiten in ein neues PDF extrahieren',
            'Nach eigenen Bereichen in separate Dateien teilen',
            'Jede Seite als eigenes PDF',
            'Mehrere Dateien werden in einem ZIP gebündelt',
            'Kein Wasserzeichen, kein Upload',
        ],
        'content' => [
            [
                'heading' => 'So schreibst du Seitenbereiche',
                'body' => 'Trenne Bereiche mit Kommas. Verwende einen Bindestrich für einen Seitenbereich wie 1-5 oder eine einzelne Zahl für eine Seite. Zum Beispiel wählt „1-3, 7, 10-12“ die Seiten 1, 2, 3, 7, 10, 11 und 12.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie extrahiere ich eine Seite aus einem PDF?', 'a' => 'Wähle „Seiten extrahieren“, gib die Seitenzahl ein (zum Beispiel 4) und klicke auf PDF teilen. Du erhältst ein neues PDF mit nur dieser Seite.'],
            ['q' => 'Kann ich jede Seite in eine eigene Datei teilen?', 'a' => 'Ja. Wähle „Jede Seite trennen“ und du erhältst ein ZIP mit einem PDF pro Seite.'],
            ['q' => 'Werden meine Dateien hochgeladen?', 'a' => 'Nein. Das PDF wird lokal in deinem Browser geteilt und verlässt nie dein Gerät.'],
            ['q' => 'Verringert das Teilen die Qualität?', 'a' => 'Nein. Die Seiten werden exakt kopiert, Text und Bilder behalten ihre ursprüngliche Qualität.'],
        ],
    ],

    'age-calculator' => [
        'name' => 'Altersrechner',
        'title' => 'Altersrechner: genaues Alter aus dem Geburtsdatum berechnen',
        'description' => 'Berechne dein genaues Alter in Jahren, Monaten und Tagen aus dem Geburtsdatum, mit gelebten Tagen und Countdown zum nächsten Geburtstag.',
        'h1' => 'Altersrechner',
        'tagline' => 'Finde dein genaues Alter in Jahren, Monaten und Tagen – plus deinen nächsten Geburtstag.',
        'keywords' => ['altersrechner', 'alter berechnen', 'geburtsdatum rechner', 'wie alt bin ich', 'alter berechnen mit geburtsdatum'],
        'intro' => 'Ein Altersrechner berechnet aus dem Geburtsdatum das genaue Alter einer Person in Jahren, Monaten und Tagen. Gib ein Geburtsdatum ein, um das genaue Alter in Jahren, Monaten und Tagen zu erfahren. Außerdem siehst du die Gesamtzahl gelebter Monate, Wochen, Tage und Stunden, den Wochentag deiner Geburt und einen Countdown bis zum nächsten Geburtstag. Du kannst das Alter auch für jedes vergangene oder zukünftige Datum berechnen.',
        'steps' => [
            'Das Geburtsdatum eingeben.',
            'Heute als Datum für „Alter am“ lassen oder ein anderes Datum wählen.',
            'Genaues Alter und Details sofort ansehen.',
        ],
        'features' => [
            'Genaues Alter in Jahren, Monaten und Tagen',
            'Monate, Wochen, Tage und Stunden insgesamt',
            'Countdown bis zum nächsten Geburtstag',
            'Wochentag deiner Geburt',
            'Berücksichtigt Schaltjahre und Geburtstage am 29. Februar',
        ],
        'content' => [
            [
                'heading' => 'So wird das Alter berechnet',
                'body' => 'Der Rechner zählt zuerst die vollen Jahre, dann die vollen Monate und dann die restlichen Tage – dieselbe Methode wie in amtlichen Formularen. Schaltjahre werden automatisch berücksichtigt, und wer am 29. Februar geboren ist, feiert in Nicht-Schaltjahren am 28. Februar.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie berechne ich mein genaues Alter?', 'a' => 'Gib dein Geburtsdatum ein, und der Rechner zeigt dein Alter in Jahren, Monaten und Tagen zum heutigen oder zu einem beliebigen anderen Datum.'],
            ['q' => 'Kann ich das Alter an einem bestimmten Datum berechnen?', 'a' => 'Ja. Ändere das Datum bei „Alter am“, um zu sehen, wie alt jemand an diesem Tag war oder sein wird – nützlich für Schulanmeldungen und Altersvoraussetzungen bei Prüfungen.'],
            ['q' => 'Wie werden Schaltjahre behandelt?', 'a' => 'Schaltjahre werden exakt gezählt. Bei einem Geburtstag am 29. Februar wird der nächste Geburtstag in einem Nicht-Schaltjahr als 28. Februar angezeigt.'],
            ['q' => 'Wird mein Geburtsdatum gespeichert?', 'a' => 'Nein. Die Berechnung läuft in deinem Browser, und nichts wird gespeichert oder irgendwohin gesendet.'],
        ],
    ],

    'percentage-calculator' => [
        'name' => 'Prozentrechner',
        'title' => 'Prozentrechner: Prozent, Veränderung und Zunahme berechnen',
        'description' => 'Kostenloser Prozentrechner: X % von Y, wie viel Prozent X von Y ist, prozentuale Zu- oder Abnahme und Prozent aufschlagen oder abziehen. Mit Formel.',
        'h1' => 'Prozentrechner',
        'tagline' => 'Alle gängigen Prozentrechnungen an einem Ort, mit Formel.',
        'keywords' => ['prozentrechner', 'prozent berechnen', 'prozentuale veränderung berechnen', 'prozentuale zunahme berechnen', 'wie viel prozent'],
        'intro' => 'Ein Prozentrechner berechnet Prozentwerte, etwa X % von Y oder die prozentuale Veränderung zwischen zwei Zahlen. Berechne Prozente im Handumdrehen: Was sind 15 % von 200, wie viel Prozent sind 30 von 120, die prozentuale Zunahme von 80 auf 100 und mehr. Jeder Rechner zeigt die verwendete Formel, damit du den Rechenweg für Hausaufgaben, Rabatte, Trinkgeld, Noten und Berichte prüfen kannst.',
        'steps' => [
            'Den Rechner suchen, der zu deiner Frage passt.',
            'Deine Zahlen in die Felder eingeben.',
            'Die Antwort und die Formel darunter ablesen.',
        ],
        'features' => [
            'Was sind X % von Y',
            'X ist wie viel Prozent von Y',
            'Prozentuale Zu- oder Abnahme von X auf Y',
            'X ist Y % von welcher Zahl',
            'Eine Zahl um einen Prozentsatz erhöhen oder verringern',
            'Formel bei jeder Antwort',
        ],
        'content' => [
            [
                'heading' => 'Prozentformeln',
                'body' => 'X % von Y = (X / 100) x Y. X als Prozent von Y = (X / Y) x 100. Prozentuale Veränderung von A nach B = ((B - A) / |A|) x 100. Ein positives Ergebnis ist eine Zunahme, ein negatives eine Abnahme.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie berechne ich den Prozentsatz einer Zahl?', 'a' => 'Teile den Prozentsatz durch 100 und multipliziere mit der Zahl. Beispiel: 15 % von 200 = 0,15 x 200 = 30.'],
            ['q' => 'Wie berechne ich eine prozentuale Zunahme?', 'a' => 'Ziehe den alten Wert vom neuen ab, teile durch den alten Wert und multipliziere mit 100. Von 80 auf 100: (100 - 80) / 80 x 100 = 25 %.'],
            ['q' => 'Wie berechne ich einen Rabatt?', 'a' => 'Nutze „Eine Zahl um einen Prozentsatz verringern“. Bei 20 % Rabatt auf 50 € beträgt der Preis 50 € x (1 - 0,20) = 40 €.'],
            ['q' => 'Warum kann ich keine Veränderung ausgehend von null berechnen?', 'a' => 'Die prozentuale Veränderung teilt durch den Anfangswert, und die Division durch null ist nicht definiert. Eine Veränderung ausgehend von 0 lässt sich daher nicht in Prozent ausdrücken.'],
        ],
        'table' => [
            'caption' => 'Prozentformeln mit Beispielen',
            'headers' => ['Frage', 'Formel', 'Beispiel'],
            'rows' => [
                ['Was sind X % von Y?', '(X / 100) × Y', '15 % von 200 = 30'],
                ['X ist wie viel % von Y?', '(X / Y) × 100', '30 von 120 = 25 %'],
                ['Veränderung in % von A nach B', '(B − A) / |A| × 100', '80 → 100 = +25 %'],
                ['Y um X % erhöhen', 'Y × (1 + X / 100)', '50 + 20 % = 60'],
                ['Y um X % verringern', 'Y × (1 − X / 100)', '50 − 20 % = 40'],
            ],
        ],
    ],

    'tip-calculator' => [
        'name' => 'Trinkgeldrechner',
        'title' => 'Trinkgeldrechner - Rechnung und Trinkgeld teilen',
        'description' => 'Kostenloser Trinkgeldrechner: Rechnung eingeben, Trinkgeld-Prozentsatz wählen und die Summe auf mehrere Personen aufteilen. Sofort, ohne Anmeldung.',
        'h1' => 'Trinkgeldrechner',
        'tagline' => 'Berechne das Trinkgeld und teile die Rechnung durch eine beliebige Anzahl Personen.',
        'keywords' => ['trinkgeldrechner', 'rechnung teilen', 'trinkgeld berechnen', 'trinkgeldrechner pro person', 'trinkgeld restaurant'],
        'intro' => 'Ein Trinkgeldrechner berechnet, wie viel Trinkgeld du auf eine Rechnung geben solltest, und teilt das Trinkgeld und die Gesamtsumme auf eine beliebige Anzahl Personen auf. Gib den Rechnungsbetrag ein, wähle einen Trinkgeld-Prozentsatz (15 %, 18 %, 20 % und 25 % sind am gängigsten, oder gib deinen eigenen ein) und die Anzahl der Personen, die sich die Rechnung teilen. Der Rechner zeigt sofort das Trinkgeld, die Summe inklusive Trinkgeld und was jede Person zahlen muss, mit der Option, den Betrag pro Person auf einen vollen Euro aufzurunden, damit niemand genau abzählen muss.',
        'steps' => [
            'Gib den Rechnungsbetrag vor dem Trinkgeld ein.',
            'Wähle einen vordefinierten Trinkgeld-Prozentsatz oder gib deinen eigenen ein.',
            'Lege fest, wie viele Personen sich die Rechnung teilen (lass es bei 1, wenn niemand teilt).',
            'Aktiviere „Aufrunden“, wenn jede Person einen vollen Betrag zahlen soll.',
            'Lies das Trinkgeld, die Summe und die Beträge pro Person unten ab.',
        ],
        'features' => [
            'Vordefinierte Trinkgeld-Prozentsätze (15 %, 18 %, 20 %, 25 %) sowie jeder eigene Prozentsatz',
            'Teilt das Trinkgeld und die Summe gleichmäßig auf eine beliebige Anzahl Personen auf',
            'Optionales Aufrunden, damit der Betrag pro Person eine volle Zahl ist',
            'Zeigt die Rechenschritte hinter jedem Ergebnis',
            'Läuft vollständig in deinem Browser: nichts, was du eingibst, wird verschickt',
        ],
        'content' => [
            [
                'heading' => 'Wie viel Trinkgeld sollte man geben?',
                'body' => 'In den USA sind 15-20 % der Rechnung die gängigste Spanne für Trinkgeld im Restaurant, wobei 20 % für guten Service, 15 % für durchschnittlichen Service und 10 % oder weniger für schlechten Service üblich sind. Lieferdienste, Taxis und Friseursalons verwenden oft niedrigere Prozentsätze, meist 10-15 %. Der richtige Betrag hängt immer von den örtlichen Gewohnheiten und dem erhaltenen Service ab, die vordefinierten Schaltflächen sind also ein Ausgangspunkt, keine feste Regel.',
            ],
            [
                'heading' => 'Eine Rechnung in einer Gruppe teilen',
                'body' => 'Stellst du „Anzahl der Personen“ auf mehr als eins, werden Trinkgeld und Summe gleichmäßig aufgeteilt - die einfachste Art, eine gemeinsame Rechnung zu teilen. Dabei wird nicht berücksichtigt, dass jede Person etwas anderes bestellt hat; in diesem Fall rechne zuerst aus, was jeder bestellt hat, und nutze diesen Rechner nur für ein Trinkgeld, das wirklich gleichmäßig aufgeteilt werden soll, etwa eine gemeinsame Vorspeise oder ein Gruppen-Trinkgeld.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie viel Trinkgeld sollte ich im Restaurant geben?', 'a' => 'In den USA sind 15-20 % der Rechnung vor Steuern die gängigste Spanne, wobei 20 % für guten Service üblich sind. Nutze eine vordefinierte Schaltfläche oder gib deinen eigenen Prozentsatz ein.'],
            ['q' => 'Berechnet man das Trinkgeld vor oder nach Steuern?', 'a' => 'Die meisten Ratgeber empfehlen, das Trinkgeld auf den Nettobetrag vor Steuern zu berechnen, auch wenn die Berechnung auf den Bruttobetrag üblich ist und nur einen kleinen Unterschied macht.'],
            ['q' => 'Wie teile ich eine Rechnung mit Freunden?', 'a' => 'Gib die Rechnung und den Trinkgeld-Prozentsatz ein und stelle „Anzahl der Personen“ auf die Anzahl der Personen, die teilen. Trinkgeld und Summe werden gleichmäßig zwischen ihnen aufgeteilt.'],
            ['q' => 'Was macht „Aufrunden“?', 'a' => 'Es rundet den Betrag, den jede Person zahlt, auf die nächste volle Zahl auf, damit niemand genau abzählen muss. Die Differenz wird dem Trinkgeld hinzugefügt.'],
            ['q' => 'Ist dieser Trinkgeldrechner kostenlos?', 'a' => 'Ja. Er ist kostenlos, ohne Anmeldung, und alles wird in deinem Browser berechnet.'],
        ],
        'table' => [
            'caption' => 'Trinkgeldbeträge bei einer Rechnung von 50 €',
            'headers' => ['Trinkgeld %', 'Trinkgeldbetrag', 'Summe mit Trinkgeld'],
            'rows' => [
                ['15 %', '7,50 €', '57,50 €'],
                ['18 %', '9,00 €', '59,00 €'],
                ['20 %', '10,00 €', '60,00 €'],
                ['25 %', '12,50 €', '62,50 €'],
            ],
        ],
    ],

    'json-formatter' => [
        'name' => 'JSON-Formatierer',
        'title' => 'JSON-Formatierer & Validator: JSON online verschönern',
        'description' => 'JSON online kostenlos formatieren, validieren und minifizieren. Fehler mit exakter Zeile und Spalte. Schnell und privat für Entwickler.',
        'h1' => 'JSON-Formatierer & Validator',
        'tagline' => 'JSON verschönern, validieren und minifizieren – mit klaren Fehlermeldungen.',
        'keywords' => ['json formatierer', 'json validator', 'json beautifier', 'json formatieren', 'json minifizieren'],
        'intro' => 'Ein JSON-Formatierer ist ein Tool, das JSON-Daten mit Zeilenumbrüchen und Einrückung lesbar macht und prüft, ob sie gültig sind. Füge JSON ein, um es mit sauberer Einrückung zu verschönern, zu validieren oder für die Produktion zu minifizieren. Ist das JSON ungültig, bekommst du eine klare Fehlermeldung mit exakter Zeile und Spalte, damit du es schnell korrigieren kannst. Deine Daten werden lokal verarbeitet und nie gesendet.',
        'steps' => [
            'Dein JSON in das Eingabefeld einfügen oder auf Beispiel klicken.',
            'Auf Formatieren zum Verschönern oder auf Minifizieren zum Komprimieren klicken.',
            'Fehler anhand der angezeigten Zeile und Spalte korrigieren.',
            'Das Ergebnis kopieren oder herunterladen.',
        ],
        'features' => [
            'Verschönern mit 2 Leerzeichen, 4 Leerzeichen oder Tabs',
            'JSON auf eine einzige Zeile minifizieren',
            'Validierung mit Zeile und Spalte des Fehlers',
            'Optionale alphabetische Sortierung der Schlüssel',
            'Kopieren und als .json herunterladen',
        ],
        'content' => [
            [
                'heading' => 'Häufige JSON-Fehler',
                'body' => 'Die häufigsten Fehler sind überzählige Kommas nach dem letzten Element, einfache statt doppelte Anführungszeichen, Schlüssel ohne Anführungszeichen und Kommentare – all das ist in Standard-JSON nicht erlaubt.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wird mein JSON an einen Server gesendet?', 'a' => 'Nein. Formatierung und Validierung laufen in deinem Browser, API-Schlüssel und private Daten bleiben also auf deinem Rechner.'],
            ['q' => 'Was ist der Unterschied zwischen Formatieren und Minifizieren?', 'a' => 'Formatieren fügt Zeilenumbrüche und Einrückungen hinzu, damit JSON lesbar wird. Minifizieren entfernt alle unnötigen Leerzeichen, damit die Datei so klein wie möglich wird.'],
            ['q' => 'Warum zeigt mein JSON einen Fehler?', 'a' => 'Prüfe Zeile und Spalte in der Meldung. Überzählige Kommas, einfache Anführungszeichen und fehlende Anführungszeichen um Schlüssel sind die üblichen Ursachen.'],
            ['q' => 'Kann es große Dateien verarbeiten?', 'a' => 'Ja. Dateien mit mehreren Megabyte werden auf den meisten Geräten in deutlich unter einer Sekunde formatiert.'],
        ],
        'table' => [
            'caption' => 'Häufige JSON-Fehler und ihre Korrektur',
            'headers' => ['Problem', 'Ungültig', 'Gültig'],
            'rows' => [
                ['Überzähliges Komma', '{"a": 1,}', '{"a": 1}'],
                ['Einfache Anführungszeichen', '{\'a\': 1}', '{"a": 1}'],
                ['Schlüssel ohne Anführungszeichen', '{a: 1}', '{"a": 1}'],
                ['Kommentar', '{"a": 1 // Notiz}', '{"a": 1}'],
            ],
        ],
    ],

    'base64-encoder-decoder' => [
        'name' => 'Base64 kodieren / dekodieren',
        'title' => 'Base64 online kodieren und dekodieren: Text und Dateien',
        'description' => 'Kodiere Text oder Dateien in Base64 und dekodiere Base64 zurück in Text. Mit UTF-8 und URL-sicherer Variante. Kostenlos und privat.',
        'h1' => 'Base64-Kodierer & -Dekodierer',
        'tagline' => 'Base64-Text und -Dateien kodieren und dekodieren, mit UTF-8 und URL-sicherer Variante.',
        'keywords' => ['base64 kodieren', 'base64 dekodieren', 'base64 konverter', 'base64 in text', 'bild in base64'],
        'intro' => 'Base64 ist eine Methode, beliebige Daten, auch Dateien, mit nur 64 Textzeichen darzustellen; Kodieren wandelt in Base64 um, Dekodieren wieder zurück. Wandle Text in Base64 um oder dekodiere Base64 zurück in lesbaren Text – mit voller Unterstützung für Emojis und nicht-englische Zeichen. Du kannst auch eine Datei oder ein Bild in eine Base64-Data-URL umwandeln, um sie in HTML, CSS oder JSON einzubetten.',
        'steps' => [
            'Modus Text oder Datei wählen.',
            'Bei Text die Eingabe einfügen und auf Kodieren oder Dekodieren klicken.',
            'Bei Dateien eine Datei wählen, um ihren Base64-String oder ihre Data-URL zu erhalten.',
            'Das Ergebnis kopieren.',
        ],
        'features' => [
            'Text mit voller UTF-8-Unterstützung kodieren und dekodieren',
            'URL-sichere Base64-Option (- und _ statt + und /)',
            'Datei und Bild in Base64 oder Data-URL',
            'Klare Fehlermeldung bei ungültigem Base64',
            'Läuft lokal – nichts wird hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Was ist Base64?',
                'body' => 'Base64 stellt Binärdaten mit 64 sicheren Textzeichen dar (A-Z, a-z, 0-9, + und /). Es wird verwendet, um Bilder in HTML und CSS einzubetten, Anhänge per E-Mail zu versenden und Daten in URLs und APIs zu übertragen. Base64 ist eine Kodierung, keine Verschlüsselung – es hält Daten also nicht geheim.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist Base64 eine Verschlüsselung?', 'a' => 'Nein. Jeder kann Base64 dekodieren. Nutze es zum Transportieren von Daten, nie zum Schutz von Passwörtern oder Geheimnissen.'],
            ['q' => 'Was ist URL-sicheres Base64?', 'a' => 'Eine Variante, die + durch - und / durch _ ersetzt und meist das Auffüllen mit = weglässt, damit der String sicher in URLs und Dateinamen verwendet werden kann.'],
            ['q' => 'Warum ist Base64 größer als das Original?', 'a' => 'Base64 macht aus je 3 Bytes 4 Zeichen, kodierte Daten sind also etwa 33 % größer als das Original.'],
            ['q' => 'Wie wandle ich ein Bild in Base64 um?', 'a' => 'Wechsle in den Datei-Modus und wähle dein Bild. Du erhältst den reinen Base64-String und eine fertige Data-URL.'],
        ],
        'table' => [
            'caption' => 'Wie viel größer Daten durch Base64 werden',
            'headers' => ['Originalgröße', 'Länge in Base64'],
            'rows' => [
                ['3 Byte', '4 Zeichen'],
                ['1 KB (1.024 Byte)', '1.368 Zeichen'],
                ['1 MB (1.048.576 Byte)', '1.398.104 Zeichen'],
            ],
        ],
    ],

    'what-is-my-ip' => [
        'name' => 'Wie ist meine IP',
        'title' => 'Wie ist meine IP-Adresse? Öffentliche IP sofort prüfen',
        'description' => 'Sieh sofort deine öffentliche IP-Adresse, ob sie IPv4 oder IPv6 ist, sowie Browser, Betriebssystem, Bildschirmgröße und Zeitzone. Kostenlose IP-Abfrage.',
        'h1' => 'Wie ist meine IP-Adresse?',
        'tagline' => 'Deine öffentliche IP-Adresse und Browserdetails – sofort.',
        'keywords' => ['wie ist meine ip', 'meine ip adresse', 'ip adresse abfragen', 'meine ip prüfen', 'was ist meine ip adresse'],
        'intro' => 'Eine IP-Adresse ist die Nummer, die deine Verbindung im Internet kennzeichnet; deine öffentliche IP ist die, die Websites sehen. Deine öffentliche IP-Adresse ist die Adresse, die Websites sehen, wenn du dich mit dem Internet verbindest. Sie wird von deinem Internetanbieter vergeben oder von deinem VPN, falls du eins nutzt. Unten siehst du deine aktuelle IP-Adresse, ob sie IPv4 oder IPv6 ist, und Details zu deinem Browser und Gerät.',
        'steps' => [
            'Diese Seite öffnen – deine IP-Adresse steht ganz oben.',
            'Auf Kopieren klicken, um sie in die Zwischenablage zu kopieren.',
            'Ein VPN ein- oder ausschalten und auf Aktualisieren klicken, um die Änderung zu sehen.',
        ],
        'features' => [
            'Öffentliche IP-Adresse mit Kopieren per Klick',
            'Erkennung von IPv4 oder IPv6',
            'Browser, Betriebssystem und Gerätetyp',
            'Bildschirmauflösung, Sprache und Zeitzone',
            'Aktualisieren, um zu prüfen, ob dein VPN funktioniert',
        ],
        'content' => [
            [
                'heading' => 'IPv4 oder IPv6',
                'body' => 'IPv4-Adressen sehen aus wie 203.0.113.42, und es gibt nur etwa 4,3 Milliarden davon. IPv6-Adressen wie 2001:db8::1 wurden eingeführt, weil die IPv4-Adressen ausgingen. Viele Verbindungen unterstützen heute beides.',
            ],
            [
                'heading' => 'Öffentliche oder private IP-Adresse',
                'body' => 'Dein Router gibt jedem Gerät zu Hause eine private IP-Adresse (oft 192.168.x.x). Das ganze Netzwerk teilt sich im Internet eine öffentliche IP-Adresse – das ist die auf dieser Seite angezeigte.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wofür wird meine IP-Adresse verwendet?', 'a' => 'Websites und Dienste nutzen deine IP-Adresse, um Daten an dich zurückzuschicken. Sie kann auch deine ungefähre Stadt und deinen Internetanbieter verraten.'],
            ['q' => 'Warum ändert sich meine IP-Adresse?', 'a' => 'Die meisten Internetanbieter vergeben dynamische IP-Adressen, die sich beim Neustart des Routers ändern können. IPs im Mobilfunk ändern sich häufig.'],
            ['q' => 'Wie kann ich meine IP-Adresse verbergen?', 'a' => 'Nutze ein VPN oder ein Anonymisierungsnetzwerk wie Tor. Websites sehen dann die IP-Adresse des VPN statt deiner.'],
            ['q' => 'Speichert ihr meine IP-Adresse?', 'a' => 'Nein. Dieses Tool zeigt dir deine IP-Adresse nur an und speichert sie in keiner Datenbank.'],
        ],
    ],

    'dice-roller' => [
        'name' => 'Würfel',
        'title' => 'Online-Würfel: virtuelle Würfel werfen (D6, D20 und mehr)',
        'description' => 'Wirf 1 bis 10 virtuelle Würfel online: D4, D6, D8, D10, D12, D20 oder D100. Faire Zufallsergebnisse mit 3D-Animation, Summe und Wurfverlauf. Kostenlos.',
        'h1' => 'Online-Würfel',
        'tagline' => 'Wirf bis zu 10 Würfel, von D4 bis D100, mit 3D-Animation und Summe.',
        'keywords' => ['würfel online', 'online würfeln', 'virtueller würfel', 'w20 würfel', 'zufallswürfel'],
        'intro' => 'Ein Online-Würfel ist ein Tool, das das Werfen von Würfeln simuliert und für jeden Würfel ein zufälliges Ergebnis liefert. Die Würfel fürs Brettspiel verloren oder du brauchst einen D20 fürs Pen-and-Paper-Rollenspiel? Dieser kostenlose Online-Würfel wirft bis zu zehn virtuelle Würfel auf einmal mit realistischer 3D-Animation. Wähle einen normalen sechsseitigen Würfel oder einen beliebigen Polyederwürfel von D4 bis D100 und sieh sofort jeden Wert, die Summe und deine letzten Würfe.',
        'steps' => [
            'Den Würfeltyp wählen: D4, D6, D8, D10, D12, D20 oder D100.',
            'Wählen, wie viele Würfel geworfen werden, von 1 bis 10.',
            'Auf Würfeln tippen (oder auf die Würfel tippen oder R drücken).',
            'Jeden Wert und die Summe ablesen. Frühere Würfe bleiben im Verlauf.',
        ],
        'features' => [
            'Sieben Würfeltypen: D4, D6, D8, D10, D12, D20 und D100',
            'Bis zu 10 Würfel auf einmal mit automatischer Summe',
            'Rollende 3D-Sechserwürfel mit echten Augenbildern',
            'Faire Ergebnisse aus dem sicheren Zufallsgenerator deines Browsers',
            'Wurfverlauf und Tastenkürzel (R, Leertaste oder Enter)',
        ],
        'content' => [
            [
                'heading' => 'Ist ein Online-Würfel fair?',
                'body' => 'Ja. Jeder Wurf nutzt die in deinen Browser eingebaute Web Crypto API – dieselbe Zufallsquelle, mit der Passwörter und Verschlüsselungsschlüssel erzeugt werden. Jede Seite hat genau dieselbe Chance, und das Ergebnis steht fest, bevor die Animation startet, sie kann es also nicht beeinflussen. Echte Würfel können dagegen durch abgerundete Kanten oder gebohrte Augen leicht unausgewogen sein.',
            ],
            [
                'heading' => 'Welche Würfel nutzen Spiele?',
                'body' => 'Die meisten Familien-Brettspiele wie Monopoly, Mensch ärgere Dich nicht und Kniffel nutzen sechsseitige Würfel (D6). Pen-and-Paper-Rollenspiele wie Dungeons & Dragons verwenden einen kompletten Satz Polyederwürfel: D4, D6, D8, D10, D12 und D20, dazu zwei D10 oder einen D100 für Prozentwürfe. Hier wechselst du mit einem Klick zwischen ihnen.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wie viele Würfel kann ich auf einmal werfen?', 'a' => 'Du kannst 1 bis 10 Würfel gleichzeitig werfen. Der Würfel zeigt jeden Wert und rechnet die Summe für dich aus.'],
            ['q' => 'Sind die Würfe wirklich zufällig?', 'a' => 'Ja. Die Würfe nutzen den kryptografisch sicheren Zufallszahlengenerator deines Browsers, jede Seite ist also gleich wahrscheinlich und die Ergebnisse sind nicht vorhersehbar.'],
            ['q' => 'Kann ich einen D20 für Dungeons & Dragons werfen?', 'a' => 'Ja. Wähle D20 bei den Würfeltypen und tippe auf Würfeln. D4, D8, D10, D12 und D100 gibt es auch.'],
            ['q' => 'Kann ich ohne Animation würfeln?', 'a' => 'Wenn dein Gerät auf „Bewegung reduzieren“ eingestellt ist, erscheinen die Ergebnisse sofort ohne Rollanimation.'],
            ['q' => 'Funktioniert der Würfel auf dem Handy?', 'a' => 'Ja. Er funktioniert in jedem modernen Browser auf Smartphones, Tablets und Computern, und du kannst zum Würfeln auf die Würfel tippen.'],
        ],
        'table' => [
            'caption' => 'Würfeltypen und wofür sie genutzt werden',
            'headers' => ['Würfel', 'Seiten', 'Typische Verwendung'],
            'rows' => [
                ['D4', '4', 'Kleine Schadenswürfe im Rollenspiel'],
                ['D6', '6', 'Brettspiele wie Monopoly und Mensch ärgere Dich nicht'],
                ['D8, D10, D12', '8, 10, 12', 'Schadens- und Fertigkeitswürfe im Rollenspiel'],
                ['D20', '20', 'Angriffswürfe und Proben bei Dungeons & Dragons'],
                ['D100', '100', 'Prozentwürfe'],
            ],
        ],
    ],

    'coin-flip' => [
        'name' => 'Münzwurf',
        'title' => 'Münzwurf: Kopf oder Zahl online werfen',
        'description' => 'Wirf online eine Münze für Kopf oder Zahl mit realistischer 3D-Animation. Bis zu 100 Münzen auf einmal, mit Summen und Serien. Kostenlos.',
        'h1' => 'Münze werfen',
        'tagline' => 'Kopf oder Zahl? Wirf eine 3D-Münze oder bis zu 100 auf einmal und sieh die Statistik.',
        'keywords' => ['münzwurf', 'münze werfen', 'kopf oder zahl', 'münze werfen online', 'virtuelle münze'],
        'intro' => 'Ein Münzwurf ist eine schnelle Art, zufällig zwischen zwei Optionen zu wählen: Kopf oder Zahl, jeweils mit 50 % Chance. Triff eine Entscheidung, bestimme, wer anfängt, oder mach ein Wahrscheinlichkeitsexperiment mit diesem kostenlosen Online-Münzwurf. Wirf eine einzelne 3D-Münze, die durch die Luft wirbelt, oder bis zu 100 Münzen auf einmal. Das Tool zählt Kopf und Zahl mit, zeigt die prozentuale Verteilung und deine aktuelle Serie.',
        'steps' => [
            'Wählen, wie viele Münzen geworfen werden: 1, 2, 5, 10, 25 oder 100.',
            'Auf Werfen tippen (oder auf die Münze tippen oder F drücken).',
            'Ergebnis, laufende Summen, Kopf/Zahl-Verteilung und Serie ansehen.',
            'Auf Statistik zurücksetzen tippen, um ein neues Experiment zu starten.',
        ],
        'features' => [
            'Realistische 3D-Münzwurf-Animation',
            'Bis zu 100 Münzen auf einmal werfen',
            'Laufende Summen, prozentuale Verteilung und aktuelle Serie',
            'Exakt 50/50-Chancen durch sicheren Zufall',
            'Tastenkürzel: F, Leertaste oder Enter',
        ],
        'content' => [
            [
                'heading' => 'Ist ein Münzwurf wirklich 50/50?',
                'body' => 'Ein virtueller Münzwurf ist hier exakt 50/50: Jedes Ergebnis kommt aus dem sicheren Zufallsgenerator deines Browsers, ohne Erinnerung an frühere Würfe. Echte Münzen landen ganz leicht häufiger auf der Seite, die beim Werfen oben lag – Forscher haben etwa 51 % gemessen. Serien von fünf oder sechs gleichen Seiten sind normal und bedeuten nicht, dass die Münze unfair ist.',
            ],
            [
                'heading' => 'Lustige Einsatzmöglichkeiten für einen Münzwurf',
                'body' => 'Mit einem Münzwurf wird entschieden, wer beim Spiel anstößt, ein Gleichstand aufgelöst, schnell Ja oder Nein entschieden, und im Unterricht wird damit Wahrscheinlichkeit erklärt. Wirf 100 Münzen auf einmal, um das Gesetz der großen Zahlen in Aktion zu sehen: Je mehr Würfe, desto näher liegt die Verteilung bei 50 %.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist dieser Münzwurf fair?', 'a' => 'Ja. Jeder Wurf hat genau 50 % Chance auf Kopf und 50 % auf Zahl, erzeugt durch den kryptografisch sicheren Zufall deines Browsers.'],
            ['q' => 'Kann ich mehr als eine Münze werfen?', 'a' => 'Ja. Wähle 2, 5, 10, 25 oder 100 Münzen – alle werden auf einmal geworfen, mit Zählung von Kopf und Zahl.'],
            ['q' => 'Warum kam fünfmal hintereinander Kopf?', 'a' => 'Serien gehören zum Zufall dazu. Die Chance auf fünfmal Kopf in Folge liegt bei etwa 3 %, das passiert bei vielen Würfen also regelmäßig.'],
            ['q' => 'Werden meine Ergebnisse gespeichert?', 'a' => 'Summen und Serie bleiben erhalten, solange die Seite geöffnet ist. Nichts wird an einen Server gesendet, und Statistik zurücksetzen löscht sie.'],
        ],
    ],

    'spin-the-wheel' => [
        'name' => 'Glücksrad',
        'title' => 'Glücksrad: zufällig Namen und Optionen auslosen',
        'description' => 'Dreh ein Glücksrad und lose einen Namen, Gewinner oder eine Option aus. Bis zu 100 Einträge, flüssige Animation, Gewinner entfernen.',
        'h1' => 'Glücksrad',
        'tagline' => 'Namen oder Optionen eintragen, drehen und das Rad einen zufälligen Gewinner wählen lassen.',
        'keywords' => ['glücksrad', 'glücksrad online', 'namen auslosen', 'namensrad', 'zufallsauswahl'],
        'intro' => 'Das Glücksrad ist ein Zufallsgenerator: Du trägst Namen oder Optionen ein, drehst, und das Rad bleibt zufällig bei einem stehen. Du kannst dich nicht entscheiden, was es zu essen gibt, wer als Nächstes dran ist oder wer das Gewinnspiel gewinnt? Trag deine Optionen in die Liste ein, eine pro Zeile, und dreh das Rad. Es dreht sich mehrmals, läuft sanft auf einem zufälligen Eintrag aus und verkündet den Gewinner. Du kannst jeden Gewinner automatisch entfernen, um Namen einzeln ohne Wiederholung zu ziehen.',
        'steps' => [
            'Einträge eintippen oder einfügen, einer pro Zeile (bis zu 100).',
            'Auf Drehen tippen, in die Radmitte klicken oder S drücken.',
            'Zusehen, wie das Rad langsamer wird und beim Gewinner stoppt.',
            'Optional „Gewinner nach jeder Drehung entfernen“ anhaken, um ohne Wiederholung zu ziehen.',
        ],
        'features' => [
            'Bis zu 100 Einträge, jeder mit eigenem farbigen Segment',
            'Flüssige Drehung, die sanft ausläuft, mit Gewinneransage',
            'Gewinner automatisch oder per Klick entfernen',
            'Reihenfolge der Einträge mischen',
            'Jeder Eintrag hat genau dieselbe Gewinnchance',
        ],
        'content' => [
            [
                'heading' => 'So wählt das Rad den Gewinner',
                'body' => 'Wenn du auf Drehen tippst, wird der Gewinner zuerst mit dem sicheren Zufallsgenerator deines Browsers bestimmt – jeder Eintrag hat dieselbe Chance, egal wie lang sein Name ist. Dann berechnet das Rad genau, wie weit es sich drehen muss, damit das gewählte Segment unter dem Zeiger stoppt, und fügt mehrere volle Umdrehungen und einen zufälligen Haltepunkt innerhalb des Segments hinzu, damit jede Drehung anders aussieht.',
            ],
            [
                'heading' => 'Ideen für ein Glücksrad',
                'body' => 'Lehrkräfte nutzen Namensräder, um Schüler fair aufzurufen, Streamer und Shops veranstalten damit Gewinnspiele, und Freunde entscheiden damit über Restaurant, Film oder Hausarbeit. Aktiviere „Gewinner nach jeder Drehung entfernen“, um eine Reihenfolge festzulegen, Teams einzuteilen oder mehrere Gewinner zu ziehen, ohne dass jemand doppelt gewinnt.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ist das Glücksrad zufällig?', 'a' => 'Ja. Der Gewinner wird mit kryptografisch sicherem Zufall bestimmt, bevor das Rad stoppt, jeder Eintrag hat also dieselbe Chance.'],
            ['q' => 'Wie viele Namen kann ich hinzufügen?', 'a' => 'Bis zu 100 Einträge. Schreib jeden in eine eigene Zeile.'],
            ['q' => 'Kann ich einen Namen nach dem Gewinn entfernen?', 'a' => 'Ja. Klicke nach einer Drehung auf Entfernen oder hake „Gewinner nach jeder Drehung entfernen“ an, damit es automatisch passiert.'],
            ['q' => 'Werden meine Einträge gespeichert oder geteilt?', 'a' => 'Nein. Deine Liste bleibt in deinem Browser und wird nie hochgeladen.'],
        ],
    ],

    'random-number-generator' => [
        'name' => 'Zufallszahlengenerator',
        'title' => 'Zufallszahlengenerator: Zahlen in jedem Bereich ziehen',
        'description' => 'Erzeuge Zufallszahlen in jedem Bereich, eine oder Hunderte auf einmal, mit oder ohne Duplikate. Ideal für Verlosungen, Lotto und Spiele. Kostenlos und sofort.',
        'h1' => 'Zufallszahlengenerator',
        'tagline' => 'Ziehe Zufallszahlen in jedem Bereich – bei Bedarf ohne Duplikate.',
        'keywords' => ['zufallszahlengenerator', 'zufallszahl', 'zahlen auslosen', 'zufallsgenerator zahlen', 'lottozahlen generator'],
        'intro' => 'Ein Zufallszahlengenerator ist ein Tool, das Zahlen zufällig aus einem von dir gewählten Bereich zieht. Erzeuge eine Zufallszahl zwischen zwei beliebigen Werten oder eine ganze Liste davon. Wähle Minimum, Maximum und Anzahl, und entscheide, ob Duplikate erlaubt sind und ob die Liste sortiert werden soll. Ideal für Verlosungen, Lotto, Unterricht, Stichproben und Spiele.',
        'steps' => [
            'Minimum und Maximum eingeben (negative Zahlen funktionieren auch).',
            'Wählen, wie viele Zahlen du willst, bis zu 1.000.',
            'Bei Bedarf „Keine Duplikate“ und „Aufsteigend sortieren“ anhaken.',
            'Auf Generieren tippen oder eine Vorgabe wie 1-100 oder 6 aus 49 nutzen.',
        ],
        'features' => [
            'Beliebiger Bereich ganzer Zahlen, auch negativ',
            'Bis zu 1.000 Zahlen auf einmal',
            'Modus ohne Duplikate für Verlosungen und Lotto',
            'Optionale Sortierung und Kopieren der Ergebnisse per Klick',
            'Sicherer, unverzerrter Zufall aus deinem Browser',
        ],
        'content' => [
            [
                'heading' => 'Wie zufällig sind die Zahlen?',
                'body' => 'Die Zahlen stammen aus der Web Crypto API, einem kryptografisch sicheren Zufallszahlengenerator, der in jeden modernen Browser eingebaut ist. Der Generator nutzt außerdem Rejection Sampling, eine Technik, die die kleine Verzerrung vieler einfacher Zufallstools beseitigt – jede Zahl im Bereich hat also exakt dieselbe Wahrscheinlichkeit.',
            ],
            [
                'heading' => 'Zahlen ohne Duplikate ziehen',
                'body' => 'Aktiviere „Keine Duplikate“, wenn jede Zahl nur einmal vorkommen darf, etwa beim Ziehen von Losen oder Lottozahlen. Das Tool prüft, ob dein Bereich groß genug ist: 10 verschiedene Zahlen zwischen 1 und 5 gehen nicht. Mit erlaubten Duplikaten wird jede Zahl unabhängig gezogen, wie beim mehrfachen Würfeln.',
            ],
        ],
        'faqs' => [
            ['q' => 'Kann ich eine Zufallszahl zwischen 1 und 100 erzeugen?', 'a' => 'Ja. Setze das Minimum auf 1 und das Maximum auf 100 oder klicke auf die Vorgabe 1-100 und tippe dann auf Generieren.'],
            ['q' => 'Kann ich Lottozahlen erzeugen?', 'a' => 'Ja. Nutze die Vorgabe „Lotto 6 aus 49“ oder wähle eigenen Bereich und Anzahl mit angehaktem „Keine Duplikate“.'],
            ['q' => 'Wie viele Zahlen kann ich auf einmal erzeugen?', 'a' => 'Bis zu 1.000 Zahlen pro Klick. Du kannst alle mit einer Schaltfläche kopieren.'],
            ['q' => 'Kann ich negative Zahlen verwenden?', 'a' => 'Ja. Alle ganzen Zahlen funktionieren, zum Beispiel ein Bereich von -50 bis 50.'],
        ],
    ],

    'stopwatch' => [
        'name' => 'Stoppuhr',
        'title' => 'Online-Stoppuhr: kostenlose Stoppuhr mit Rundenzeiten',
        'description' => 'Kostenlose Online-Stoppuhr, genau auf 1/100 Sekunde, mit Runden- und Zwischenzeiten, schnellster und langsamster Runde und Tastenkürzeln.',
        'h1' => 'Online-Stoppuhr',
        'tagline' => 'Genau auf 1/100 Sekunde, mit Runden, Zwischenzeiten und Tastenkürzeln.',
        'keywords' => ['stoppuhr', 'online stoppuhr', 'stoppuhr mit runden', 'timer', 'rundenzeit'],
        'intro' => 'Eine Stoppuhr misst die Zeit zwischen Start und Stopp und kann Rundenzeiten festhalten. Stoppe einen Lauf, eine Präsentation, ein Rezept oder ein Training mit dieser kostenlosen Online-Stoppuhr. Sie zählt auf die Hundertstelsekunde, speichert Runden- und Zwischenzeiten und hebt deine schnellste und langsamste Runde hervor. Da sie die tatsächlich vergangene Zeit misst, bleibt sie auch beim Tab-Wechsel genau.',
        'steps' => [
            'Auf Start (oder die Leertaste) drücken, um die Zeitmessung zu starten.',
            'Auf Runde (oder L) drücken, um eine Runde ohne Anhalten zu speichern.',
            'Auf Stopp drücken zum Pausieren, dann auf Fortsetzen zum Weitermachen.',
            'Auf Zurücksetzen (oder R) drücken, um Zeit und Runden zu löschen. Mit Runden kopieren fügst du sie überall ein.',
        ],
        'features' => [
            'Genau auf 1/100 Sekunde',
            'Unbegrenzte Runden mit Runden- und Gesamtzeit (Zwischenzeit)',
            'Schnellste und langsamste Runde hervorgehoben',
            'Tastenkürzel: Leertaste, L und R',
            'Bleibt in Hintergrund-Tabs exakt',
        ],
        'content' => [
            [
                'heading' => 'Wie genau ist eine Online-Stoppuhr?',
                'body' => 'Diese Stoppuhr liest bei jeder Aktualisierung der Anzeige die hochauflösende Uhr deines Geräts, statt Timer-Ticks zu zählen – kleine Verzögerungen summieren sich also nie. Browser bremsen Seiten in Hintergrund-Tabs aus, aber da die vergangene Zeit immer vom Startzeitpunkt aus berechnet wird, stimmt die Anzeige, wenn du zurückkommst.',
            ],
            [
                'heading' => 'Rundenzeit oder Zwischenzeit',
                'body' => 'Die Rundenzeit ist die Dauer einer einzelnen Runde, zum Beispiel 1:05 für die dritte Runde auf der Bahn. Die Zwischenzeit (oder Gesamtzeit) ist die Zeit seit dem Start, zum Beispiel 3:20 am Ende der dritten Runde. Die Rundentabelle zeigt beides, damit du Tempo und Gesamtfortschritt auf einen Blick siehst.',
            ],
        ],
        'faqs' => [
            ['q' => 'Läuft die Stoppuhr in einem anderen Tab weiter?', 'a' => 'Ja. Sie misst die tatsächlich vergangene Zeit, die Anzeige stimmt also auch, nachdem der Tab im Hintergrund war.'],
            ['q' => 'Wie speichere ich eine Runde?', 'a' => 'Drücke Runde, während die Stoppuhr läuft, oder die Taste L. Jede Runde zeigt ihre eigene Zeit und die Gesamtzeit.'],
            ['q' => 'Kann ich die Tastatur nutzen?', 'a' => 'Ja. Die Leertaste startet und stoppt, L speichert eine Runde und R setzt im gestoppten Zustand zurück.'],
            ['q' => 'Kann ich meine Rundenzeiten speichern?', 'a' => 'Drücke Runden kopieren, um alle Runden- und Gesamtzeiten zu kopieren, und füge sie in eine Tabelle, Notiz oder Nachricht ein.'],
        ],
    ],

    'countdown-timer' => [
        'name' => 'Countdown-Timer',
        'title' => 'Countdown-Timer: Online-Timer mit Alarm',
        'description' => 'Countdown-Timer für Sekunden, Minuten oder Stunden mit Vorgaben per Klick. Ein Alarm ertönt am Ende, der Tab zeigt die Restzeit. Kostenlos.',
        'h1' => 'Countdown-Timer',
        'tagline' => 'Minuten oder Stunden einstellen oder eine Vorgabe antippen. Ein Alarm ertönt, wenn die Zeit um ist.',
        'keywords' => ['countdown timer', 'online timer', 'timer mit alarm', '5 minuten timer', 'timer stellen'],
        'intro' => 'Ein Countdown-Timer zählt eine eingestellte Zeit bis null herunter und löst dann einen Alarm aus. Stell einen Timer fürs Kochen, Lernen, Training, Meetings oder Prüfungen. Gib eine beliebige Dauer bis 99 Stunden ein oder tippe auf eine Vorgabe wie 5 oder 25 Minuten. Ein Ring zählt die Restzeit herunter, der Browser-Tab zeigt sie an, und ein Alarm ertönt, wenn der Countdown null erreicht.',
        'steps' => [
            'Stunden, Minuten und Sekunden eingeben oder eine Vorgabe antippen.',
            'Auf Start (oder Leertaste) drücken. Ring und Tab-Titel zählen herunter.',
            'Jederzeit pausieren, fortsetzen oder eine Minute hinzufügen.',
            'Wenn der Alarm ertönt, auf Alarm stoppen und dann auf Neuer Timer drücken.',
        ],
        'features' => [
            'Jede Dauer von 1 Sekunde bis 99 Stunden 59 Minuten',
            'Vorgaben per Klick von 30 Sekunden bis 1 Stunde',
            'Alarmton, auf Wunsch abschaltbar',
            'Restzeit im Titel des Browser-Tabs',
            'Pause, Fortsetzen und +1 Minute, mit Tastenkürzeln',
        ],
        'content' => [
            [
                'heading' => 'Funktioniert der Timer in einem Hintergrund-Tab?',
                'body' => 'Ja. Der Timer berechnet den exakten Endzeitpunkt, er bleibt also genau, auch wenn du den Tab wechselst und der Browser die Seite ausbremst. Die Restzeit steht außerdem im Tab-Titel, sodass du sie im Blick behältst, während du in einem anderen Tab arbeitest. Lass den Tab offen und den Ton an, um den Alarm zu hören.',
            ],
            [
                'heading' => 'Beliebte Timer-Längen',
                'body' => 'Fünf Minuten sind ideal für Tee, kurze Pausen und schnelle Übungen. Fünfundzwanzig Minuten sind die klassische Pomodoro-Fokuseinheit, meist gefolgt von fünf Minuten Pause. Längere Timer von 30 oder 60 Minuten passen zu Prüfungen, Meetings und zum Backen. Nutze dafür die Vorgaben oder gib eine andere Dauer ein.',
            ],
        ],
        'faqs' => [
            ['q' => 'Gibt der Countdown-Timer einen Ton aus?', 'a' => 'Ja. Ein Alarm piept, wenn die Zeit um ist – bis zu 30 Sekunden lang oder bis du auf Alarm stoppen drückst. Du kannst den Ton ausschalten.'],
            ['q' => 'Warum habe ich den Alarm nicht gehört?', 'a' => 'Prüfe, ob die Lautstärke aufgedreht und der Tab noch geöffnet ist. Browser erlauben Ton erst nach einem Klick auf die Seite – der passiert, wenn du auf Start drückst.'],
            ['q' => 'Wie lang kann der Timer maximal sein?', 'a' => 'Bis zu 99 Stunden, 59 Minuten und 59 Sekunden.'],
            ['q' => 'Kann ich den Timer pausieren?', 'a' => 'Ja. Drücke Pause (oder Leertaste) und Fortsetzen zum Weitermachen. Du kannst auch während des Laufs eine Minute hinzufügen.'],
        ],
    ],

    'sleep-calculator' => [
        'name' => 'Schlafrechner',
        'title' => 'Schlafrechner: beste Zeit zum Schlafen und Aufwachen',
        'description' => 'Finde die beste Zeit zum Schlafengehen oder Aufwachen nach 90-Minuten-Schlafzyklen oder zähle deine Schlafstunden. Erholt aufwachen.',
        'h1' => 'Schlafrechner',
        'tagline' => 'Finde die beste Schlafens- oder Aufwachzeit und zähle deine geschlafenen Stunden.',
        'keywords' => ['schlafrechner', 'schlafzähler', 'wann schlafen gehen', 'schlafzyklus rechner', 'wann sollte ich ins bett gehen', 'stunden schlaf'],
        'intro' => 'Ein Schlafrechner schlägt Schlafens- oder Aufwachzeiten vor, damit du am Ende eines Schlafzyklus aufwachst, wenn der Schlaf am leichtesten ist. Wenn du mitten in einem Schlafzyklus aufwachst, fühlst du dich nach dem Weckerklingeln benommen – selbst nach einer ganzen Nacht. Dieser Schlafrechner richtet sich nach dem natürlichen Rhythmus der etwa 90-minütigen Schlafzyklen: Sag ihm, wann du aufstehen musst, und er schlägt vor, wann du ins Bett gehen solltest, oder sag ihm, wann du schlafen gehst, und er schlägt die besten Weckzeiten vor. Er kann auch zählen, wie viele Stunden du geschlafen hast, und sie mit den empfohlenen 7-9 Stunden vergleichen.',
        'steps' => [
            'Wählen, was berechnet werden soll: Schlafenszeit, Aufwachzeit, „Jetzt schlafen“ oder geschlafene Stunden.',
            'Die Uhrzeit eingeben. Anpassen, wie lange du normalerweise zum Einschlafen brauchst (standardmäßig 15 Minuten).',
            'Eine der vorgeschlagenen Zeiten wählen. „Empfohlen“ ergibt 7,5 Stunden, „Beste Erholung“ 9 Stunden Schlaf.',
            'Auf eine Zeit tippen, um ein Diagramm deiner Schlafzyklen in dieser Nacht zu sehen.',
        ],
        'features' => [
            'Schlafenszeiten für eine gewünschte Aufwachzeit und Aufwachzeiten für eine gewünschte Schlafenszeit',
            'Modus „Jetzt schlafen“ mit der aktuellen Uhrzeit',
            'Zähler für geschlafene Stunden mit der 7-9-Stunden-Empfehlung',
            'Einstellbare Einschlafzeit und 12- oder 24-Stunden-Uhr',
            'Animiertes Diagramm von leichtem, tiefem und REM-Schlaf über die Nacht',
        ],
        'content' => [
            [
                'heading' => 'Was ist ein Schlafzyklus?',
                'body' => 'Nachts durchläufst du leichten Schlaf, Tiefschlaf und REM-Schlaf (Traumschlaf) in Zyklen von etwa 90 Minuten, meist vier- bis sechsmal pro Nacht. Frühe Zyklen enthalten den meisten Tiefschlaf, spätere mehr REM-Schlaf. Am Ende eines Zyklus aufzuwachen, wenn der Schlaf am leichtesten ist, fällt meist leichter, als aus dem Tiefschlaf geweckt zu werden.',
            ],
            [
                'heading' => 'Wie viel Schlaf brauchst du?',
                'body' => 'Schlafgesundheitsorganisationen empfehlen Erwachsenen 7 bis 9 Stunden pro Nacht, Jugendlichen 8 bis 10 Stunden und Schulkindern 9 bis 12 Stunden. Fünf volle Zyklen (7,5 Stunden) oder sechs Zyklen (9 Stunden) passen zu diesen Empfehlungen für Erwachsene. Jeder Mensch ist etwas anders und die Zykluslänge variiert, betrachte die vorgeschlagenen Zeiten also als hilfreiche Orientierung, nicht als feste Regel.',
            ],
        ],
        'faqs' => [
            ['q' => 'Wann sollte ich ins Bett gehen, um um 7 Uhr aufzuwachen?', 'a' => 'Für 7:00 Uhr solltest du um 23:30 Uhr einschlafen, um fünf Zyklen (7,5 Stunden) zu schaffen, oder um 22:00 Uhr für sechs Zyklen (9 Stunden). Mit 15 Minuten zum Einschlafen heißt das: um 23:15 Uhr oder 21:45 Uhr ins Bett.'],
            ['q' => 'Wie lange dauert ein Schlafzyklus?', 'a' => 'Ein Schlafzyklus dauert im Durchschnitt etwa 90 Minuten, kann aber je nach Person und im Laufe der Nacht zwischen etwa 80 und 120 Minuten schwanken.'],
            ['q' => 'Warum bin ich nach 8 Stunden Schlaf müde?', 'a' => 'Wenn dein Wecker im Tiefschlaf klingelt, kannst du dich selbst nach einer langen Nacht benommen fühlen. Den Wecker aufs Ende eines Zyklus zu stellen und feste Schlafzeiten einzuhalten, hilft oft.'],
            ['q' => 'Wie berechnet der Schlafzähler die geschlafenen Stunden?', 'a' => 'Wähle „Geschlafene Stunden“ und gib ein, wann du ins Bett gegangen und wann du aufgewacht bist. Er rechnet über Mitternacht hinweg, zieht die Einschlafzeit ab und vergleicht das Ergebnis mit den 7-9 Stunden, die Erwachsene brauchen.'],
            ['q' => 'Ist dieser Schlafrechner eine medizinische Beratung?', 'a' => 'Nein. Er ist eine allgemeine Orientierung auf Basis durchschnittlicher Schlafzyklen. Wenn du regelmäßig schlecht schläfst, sprich mit einer Ärztin oder einem Arzt.'],
        ],
        'table' => [
            'caption' => 'Schlafenszeiten für übliche Aufwachzeiten (15 Minuten zum Einschlafen)',
            'headers' => ['Aufwachen um', '6 Zyklen (9 Std.)', '5 Zyklen (7,5 Std.)', '4 Zyklen (6 Std.)'],
            'rows' => [
                ['06:00', '20:45', '22:15', '23:45'],
                ['06:30', '21:15', '22:45', '00:15'],
                ['07:00', '21:45', '23:15', '00:45'],
                ['07:30', '22:15', '23:45', '01:15'],
                ['08:00', '22:45', '00:15', '01:45'],
            ],
        ],
    ],

    'avif-to-jpg' => [
        'name' => 'AVIF in JPG',
        'title' => 'AVIF in JPG umwandeln - kostenlos, privat, Stapel',
        'description' => 'AVIF kostenlos online in JPG umwandeln. Bis zu 30 Bilder auf einmal, Qualität wählbar, Download als ZIP. Ihre Bilder verlassen nie Ihr Gerät.',
        'h1' => 'AVIF in JPG umwandeln',
        'tagline' => 'Machen Sie aus AVIF-Bildern JPGs, die sich überall öffnen.',
        'keywords' => ['avif in jpg', 'avif in jpg umwandeln', 'avif zu jpg', 'avif in jpeg', 'avif datei öffnen'],
        'intro' => 'AVIF ist ein modernes Bildformat auf Basis des Videocodecs AV1, das sehr kleine Dateien erzeugt, doch viele Programme, Bildbearbeitungen und Upload-Formulare können es noch nicht öffnen. Dieser AVIF-zu-JPG-Konverter wandelt Ihre AVIF-Bilder in JPG um, das am weitesten verbreitete Bildformat. Ziehen Sie ein Bild oder einen ganzen Stapel hinein, wählen Sie die Qualität und laden Sie die Ergebnisse einzeln oder als ZIP herunter.',
        'steps' => [
            'Ziehen Sie Ihre AVIF-Bilder in das Feld oder klicken Sie, um sie auszuwählen (bis zu 30 auf einmal).',
            'Passen Sie bei Bedarf die JPG-Qualität an; 85 % hält Fotos scharf bei kleiner Dateigröße.',
            'Klicken Sie neben einem Bild auf Herunterladen oder auf Alle herunterladen (ZIP) für den ganzen Stapel.',
        ],
        'features' => [
            'Wandelt AVIF in Ihrem Browser in JPG um',
            'Bis zu 30 Bilder pro Stapel mit ZIP-Download',
            'Einstellbare JPG-Qualität',
            '100 % privat: Es wird nichts hochgeladen',
        ],
        'content' => [
            ['heading' => 'Warum AVIF in JPG umwandeln?', 'body' => 'AVIF-Dateien sind bei gleicher Bildqualität oft 30 bis 50 % kleiner als JPGs, deshalb liefern viele Websites ihre Bilder inzwischen als AVIF aus. Speichern Sie ein solches Bild, verweigern ältere Bildprogramme, Office-Dokumente, Drucker und manche soziale Netzwerke oft das Öffnen. JPG funktioniert fast überall – nach der Umwandlung haben Sie also eine Datei, die Sie überall nutzen können.'],
            ['heading' => 'Was passiert mit der Transparenz?', 'body' => 'JPG unterstützt keine Transparenz. Hat Ihr AVIF-Bild transparente Bereiche, werden sie im JPG weiß gefüllt. Um die Transparenz zu behalten, nutzen Sie stattdessen den AVIF-zu-PNG-Konverter.'],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich AVIF in JPG um?', 'a' => 'Ziehen Sie die AVIF-Datei in das Feld oben. Sie wird sofort in JPG umgewandelt und Sie laden sie mit einem Klick herunter.'],
            ['q' => 'Warum kann ich AVIF-Dateien nicht öffnen?', 'a' => 'AVIF ist ein neueres Format. Aktuelle Browser öffnen es, viele ältere Programme und Bildbearbeitungen aber noch nicht – die Umwandlung in JPG ist die einfachste Lösung.'],
            ['q' => 'Wird das JPG größer als die AVIF-Datei?', 'a' => 'Meistens ja. AVIF komprimiert Bilder effizienter als JPG, daher braucht dasselbe Bild als JPG mehr Platz.'],
            ['q' => 'Werden meine Bilder hochgeladen?', 'a' => 'Nein. Ihr Browser dekodiert das AVIF und speichert das JPG auf Ihrem Gerät – Ihre Bilder verlassen nie Ihren Computer oder Ihr Handy.'],
        ],
    ],

    'avif-to-png' => [
        'name' => 'AVIF in PNG',
        'title' => 'AVIF in PNG umwandeln - kostenlos, mit Transparenz',
        'description' => 'AVIF kostenlos online in PNG umwandeln. Transparente Hintergründe bleiben erhalten, bis zu 30 Bilder pro Stapel, Download als ZIP. Kein Upload.',
        'h1' => 'AVIF in PNG umwandeln',
        'tagline' => 'Wandeln Sie AVIF-Bilder in PNG um – mit Transparenz.',
        'keywords' => ['avif in png', 'avif in png umwandeln', 'avif zu png', 'avif konverter', 'avif in png transparent'],
        'intro' => 'Beim Umwandeln von AVIF in PNG wird ein modernes, stark komprimiertes AVIF-Bild zu einem verlustfreien PNG, das fast jedes Programm öffnen kann. Transparente Hintergründe bleiben transparent, deshalb ist PNG die richtige Wahl für Logos, Icons und Grafiken. Ziehen Sie ein Bild oder einen Stapel hinein und laden Sie die Ergebnisse einzeln oder als ZIP herunter.',
        'steps' => [
            'Ziehen Sie Ihre AVIF-Bilder in das Feld oder klicken Sie, um sie auszuwählen (bis zu 30 auf einmal).',
            'Jedes Bild wird sofort in Ihrem Browser in PNG umgewandelt.',
            'Klicken Sie neben einem Bild auf Herunterladen oder auf Alle herunterladen (ZIP) für den ganzen Stapel.',
        ],
        'features' => [
            'Wandelt AVIF verlustfrei in PNG um',
            'Transparente Hintergründe bleiben erhalten',
            'Bis zu 30 Bilder pro Stapel mit ZIP-Download',
            '100 % privat: Es wird nichts hochgeladen',
        ],
        'content' => [
            ['heading' => 'Wann ist PNG besser als JPG?', 'body' => 'Wählen Sie PNG für Logos, Icons, Screenshots und alle Bilder mit transparenten Bereichen oder scharfen Kanten, denn PNG ist verlustfrei und unterstützt Transparenz. Für normale Fotos erzeugt JPG deutlich kleinere Dateien – dann ist AVIF in JPG meist die bessere Wahl.'],
            ['heading' => 'Verliert das Bild beim Umwandeln in PNG an Qualität?', 'body' => 'Die Umwandlung selbst verursacht keinen Verlust, weil PNG jedes Pixel exakt speichert. Wurde das ursprüngliche AVIF verlustbehaftet komprimiert, bleibt dieser frühere Verlust bestehen, es kommt aber kein neuer hinzu.'],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich AVIF in PNG um?', 'a' => 'Ziehen Sie die AVIF-Datei in das Feld oben. Sie wird sofort in PNG umgewandelt und Sie laden sie mit einem Klick herunter.'],
            ['q' => 'Bleibt die Transparenz erhalten?', 'a' => 'Ja. PNG unterstützt Transparenz, daher bleiben transparente Bereiche des AVIF auch im PNG transparent.'],
            ['q' => 'Warum ist das PNG so viel größer?', 'a' => 'AVIF komprimiert sehr effizient, PNG dagegen verlustfrei – dasselbe Bild kann als PNG um ein Vielfaches größer sein.'],
            ['q' => 'Werden meine Bilder hochgeladen?', 'a' => 'Nein. Die Umwandlung läuft in Ihrem Browser und Ihre Bilder verlassen nie Ihr Gerät.'],
        ],
    ],

    'avif-to-webp' => [
        'name' => 'AVIF in WebP',
        'title' => 'AVIF in WebP umwandeln - kostenlos online, Stapel',
        'description' => 'AVIF kostenlos online in WebP umwandeln. Kleine Dateien und Transparenz bleiben, bis zu 30 Bilder pro Stapel, Download als ZIP. Kein Upload.',
        'h1' => 'AVIF in WebP umwandeln',
        'tagline' => 'Wandeln Sie AVIF in WebP um und behalten Sie kleine Dateien.',
        'keywords' => ['avif in webp', 'avif in webp umwandeln', 'avif zu webp', 'avif webp', 'avif konverter online'],
        'intro' => 'Durch das Umwandeln von AVIF in WebP erhalten Sie ein kleines, webtaugliches Bild, das mehr Programme und Content-Management-Systeme akzeptieren als AVIF. WebP behält die Transparenz und komprimiert gut, sodass die Dateien deutlich kleiner bleiben als PNG oder JPG. Ziehen Sie ein Bild oder einen Stapel hinein, wählen Sie die Qualität und laden Sie die Ergebnisse herunter.',
        'steps' => [
            'Ziehen Sie Ihre AVIF-Bilder in das Feld oder klicken Sie, um sie auszuwählen (bis zu 30 auf einmal).',
            'Passen Sie bei Bedarf die WebP-Qualität an; 85 % ist ein guter Kompromiss aus Größe und Schärfe.',
            'Klicken Sie neben einem Bild auf Herunterladen oder auf Alle herunterladen (ZIP) für den ganzen Stapel.',
        ],
        'features' => [
            'Wandelt AVIF in Ihrem Browser in WebP um',
            'Transparente Hintergründe bleiben erhalten',
            'Einstellbare Qualität und ZIP-Download',
            '100 % privat: Es wird nichts hochgeladen',
        ],
        'content' => [
            ['heading' => 'AVIF oder WebP: Was soll ich nutzen?', 'body' => 'Beide sind moderne Formate mit Transparenz. AVIF erzeugt meist kleinere Dateien, WebP gibt es aber schon länger und es wird von mehr Programmen, Plugins und Upload-Formularen akzeptiert. Die Umwandlung in WebP ist ein guter Mittelweg, wenn eine Website oder ein Tool kein AVIF annimmt, Sie aber kleine Bilder möchten.'],
            ['heading' => 'Sieht das WebP genauso aus?', 'body' => 'Ab 85 % Qualität ist der Unterschied kaum zu erkennen. Jedes verlustbehaftete Speichern kann etwas Detail kosten – zum Archivieren oder Weiterbearbeiten behält AVIF in PNG dagegen jedes Pixel.'],
        ],
        'faqs' => [
            ['q' => 'Wie wandle ich AVIF in WebP um?', 'a' => 'Ziehen Sie die AVIF-Datei in das Feld oben, wählen Sie die Qualität und laden Sie das WebP mit einem Klick herunter.'],
            ['q' => 'Bleibt die Transparenz erhalten?', 'a' => 'Ja. WebP unterstützt Transparenz, daher bleiben transparente Bereiche erhalten.'],
            ['q' => 'Welche Browser können das?', 'a' => 'Aktuelle Versionen von Chrome, Edge, Firefox und Safari können AVIF lesen und WebP speichern, daher funktioniert der Konverter in allen.'],
            ['q' => 'Werden meine Bilder hochgeladen?', 'a' => 'Nein. Alles passiert in Ihrem Browser und Ihre Bilder verlassen nie Ihr Gerät.'],
        ],
    ],

    'readability-checker' => [
        'name' => 'Lesbarkeitsprüfer',
        'title' => 'Lesbarkeitsprüfer kostenlos: Flesch-Wert & Niveau',
        'description' => 'Kostenloser Lesbarkeitsprüfer: Flesch-Lesbarkeitswert, Klassenstufe, Gunning Fog und SMOG berechnen und zu lange Sätze finden. Ihr Text bleibt privat.',
        'h1' => 'Lesbarkeitsprüfer',
        'tagline' => 'Sehen Sie, wie leicht Ihr Text lesbar ist – und was Sie verbessern können.',
        'keywords' => ['lesbarkeit prüfen', 'lesbarkeitsprüfer', 'lesbarkeitsindex', 'flesch index', 'flesch reading ease', 'lesbarkeitstest'],
        'intro' => 'Ein Lesbarkeitsprüfer misst, wie leicht ein Text zu lesen ist – mit Formeln, die auf Satz- und Wortlänge beruhen. Fügen Sie einen Artikel, eine Hausarbeit, eine E-Mail oder einen KI-Entwurf ein und erhalten Sie den Flesch-Lesbarkeitswert, die Klassenstufe nach fünf Formeln und eine Liste zu langer Sätze. Ihr Text wird in Ihrem Browser analysiert und nie hochgeladen.',
        'steps' => [
            'Fügen Sie Ihren Text in das Feld ein oder tippen Sie ihn.',
            'Lesen Sie den Flesch-Wert und die Klassenstufe jeder Formel ab.',
            'Kürzen Sie die unter den Ergebnissen aufgeführten langen Sätze und prüfen Sie erneut.',
        ],
        'features' => [
            'Flesch-Lesbarkeitswert und Flesch-Kincaid-Klassenstufe',
            'Gunning Fog, SMOG, Coleman-Liau und ARI',
            'Markiert Sätze mit mehr als 25 Wörtern',
            'Sofortige Ergebnisse; nichts wird hochgeladen',
        ],
        'content' => [
            ['heading' => 'Was ist ein guter Lesbarkeitswert?', 'body' => 'Für die meisten Websites, Blogs und E-Mails sollten Sie einen Flesch-Wert von mindestens 60 anstreben – das ist einfache Sprache, die fast alle Erwachsenen mühelos lesen – und eine Klassenstufe von etwa 8 oder darunter. Fach- und wissenschaftliche Texte liegen oft bei 30 bis 50, was für Fachleute passt, für alle anderen aber schwer ist.'],
            ['heading' => 'Wie mache ich meinen Text leichter lesbar?', 'body' => 'Teilen Sie lange Sätze, verwenden Sie kurze Alltagswörter statt langer, schreiben Sie aktiv und gliedern Sie große Absätze. Diese Änderungen erhöhen den Flesch-Wert direkt, weil er aus Wörtern pro Satz und Silben pro Wort berechnet wird.'],
        ],
        'faqs' => [
            ['q' => 'Was ist der Flesch-Lesbarkeitswert?', 'a' => 'Ein Wert von 0 bis 100, der auf der durchschnittlichen Satzlänge und den Silben pro Wort beruht. Je höher, desto leichter: 60-70 ist einfache Sprache, über 90 sehr leicht.'],
            ['q' => 'Was bedeutet die Klassenstufe?', 'a' => 'Sie gibt die US-Schulklasse an, die ein Leser braucht, um den Text zu verstehen. Stufe 8 entspricht einem typischen 13- bis 14-Jährigen.'],
            ['q' => 'Kann ich KI-Texte prüfen?', 'a' => 'Ja. KI-Entwürfe enthalten oft lange Sätze und lange Wörter; der Prüfer zeigt, welche Sätze Sie kürzen sollten, damit der Text natürlicher klingt.'],
            ['q' => 'Funktioniert das auch auf Deutsch?', 'a' => 'Die Formeln wurden für Englisch entwickelt, deshalb sind die Ergebnisse für deutsche Texte nur ein grober Anhaltspunkt.'],
        ],
        'table' => [
            'caption' => 'Flesch-Lesbarkeitswerte',
            'headers' => ['Wert', 'Niveau', 'Typischer Leser'],
            'rows' => [
                ['90-100', 'Sehr leicht', '11 Jahre'],
                ['60-70', 'Einfache Sprache', '13-15 Jahre'],
                ['30-50', 'Schwer', 'Studium'],
                ['0-30', 'Sehr schwer', 'Hochschulabsolvent'],
            ],
        ],
    ],

    'ai-content-detector' => [
        'name' => 'KI-Text-Detektor',
        'title' => 'KI-Detektor kostenlos: KI-Texte erkennen',
        'description' => 'Kostenloser KI-Detektor: Prüfen Sie, ob ein Text KI-generiert wirkt – mit Wert, den verräterischen Formulierungen und vier Schreibsignalen. Privat.',
        'h1' => 'KI-Text-Detektor',
        'tagline' => 'Prüfen Sie, wie KI-typisch ein Text wirkt – und warum.',
        'keywords' => ['ki detektor', 'ki text erkennen', 'ki checker', 'chatgpt detektor', 'ki generierten text erkennen', 'ai detector kostenlos'],
        'intro' => 'Ein KI-Text-Detektor schätzt, ob ein Text von einem KI-Chatbot wie ChatGPT geschrieben wurde. Dieser analysiert vier Signale, in denen sich typische KI-Texte von menschlichen unterscheiden: wie gleichmäßig die Sätze sind, KI-typische Formulierungen, Kurzformen und die Vielfalt des Wortschatzes. Er liefert einen Wert und zeigt genau, was ihn erhöht hat. Er analysiert englische Texte in Ihrem Browser, ohne etwas hochzuladen.',
        'steps' => [
            'Fügen Sie mindestens 80 Wörter englischen Text in das Feld ein.',
            'Klicken Sie auf Text prüfen, um den Wert und die vier Signale zu sehen.',
            'Sehen Sie sich die gefundenen KI-typischen Formulierungen an; umformuliert klingt der Text menschlicher.',
        ],
        'features' => [
            'KI-Ähnlichkeitswert von 0 bis 100 %',
            'Zeigt die gefundenen KI-typischen Formulierungen',
            'Erklärt jedes Signal verständlich',
            'Kostenlos, unbegrenzt und privat: Es wird nichts hochgeladen',
        ],
        'content' => [
            ['heading' => 'Wie funktioniert KI-Erkennung?', 'body' => 'KI-Modelle schreiben oft sehr gleichmäßige Sätze, wiederholen dieselben polierten Wendungen („moreover“, „it is important to note“, „delve“) und vermeiden Kurzformen. Menschen mischen eher kurze und lange Sätze und schreiben lockerer. Der Detektor misst diese Muster und fasst sie zu einem Wert zusammen.'],
            ['heading' => 'Wie zuverlässig sind KI-Detektoren?', 'body' => 'Kein KI-Detektor ist völlig zuverlässig. Sehr förmliche menschliche Texte können hoch bewertet werden, und überarbeitete oder locker formulierte KI-Texte niedrig. Betrachten Sie den Wert als Hinweis, genauer hinzusehen – nie als Beweis, und nutzen Sie ihn nie allein, um Schülern oder Autoren Täuschung vorzuwerfen.'],
        ],
        'faqs' => [
            ['q' => 'Erkennt er ChatGPT?', 'a' => 'Er markiert Schreibmuster, die ChatGPT und ähnliche Modelle oft erzeugen. Überarbeitete oder gezielt gesteuerte KI-Texte werden möglicherweise nicht erkannt.'],
            ['q' => 'Wie viel Text brauche ich?', 'a' => 'Mindestens 80 Wörter. Ab etwa 300 Wörtern ist der Wert aussagekräftiger.'],
            ['q' => 'Kann ein menschlicher Text als KI gelten?', 'a' => 'Ja. Ein sehr förmlicher, gleichmäßiger Text mit Wörtern wie „furthermore“ kann hoch bewertet werden, auch wenn ein Mensch ihn geschrieben hat. Deshalb ist der Wert nur ein Anhaltspunkt.'],
            ['q' => 'Wird mein Text gespeichert?', 'a' => 'Nein. Die Analyse läuft in Ihrem Browser und Ihr Text wird nirgendwohin gesendet.'],
        ],
    ],

    'remove-background' => [
        'name' => 'Hintergrund entfernen',
        'title' => 'Hintergrund entfernen - kostenlos, ohne Upload',
        'description' => 'Entfernen Sie kostenlos mit KI den Hintergrund aus jedem Bild. Transparentes PNG oder farbiger Hintergrund in Sekunden. Läuft im Browser, ohne Upload.',
        'h1' => 'Bildhintergrund entfernen',
        'tagline' => 'Stellen Sie Personen, Produkte und Tiere mit einem Klick frei.',
        'keywords' => [
            'hintergrund entfernen',
            'bild hintergrund entfernen',
            'foto freistellen',
            'transparenter hintergrund',
            'remove bg',
            'png transparent machen',
        ],
        'intro' => 'Ein Hintergrundentferner stellt das Hauptmotiv eines Fotos frei und macht alles dahinter transparent. Dieser nutzt ein KI-Modell, das in Ihrem Browser läuft: Ziehen Sie das Foto einer Person, eines Produkts, eines Haustiers oder eines Logos hinein und laden Sie ein transparentes PNG herunter – oder setzen Sie es auf Weiß oder eine beliebige Farbe. Ihr Bild wird nie hochgeladen; nur das KI-Modell wird einmal heruntergeladen.',
        'steps' => [
            'Ziehen Sie ein JPG-, PNG-, WebP- oder AVIF-Bild in das Feld.',
            'Warten Sie einige Sekunden, während die KI den Hintergrund entfernt (beim ersten Mal wird auch das Modell geladen).',
            'Wählen Sie einen transparenten, weißen oder farbigen Hintergrund und klicken Sie auf PNG herunterladen.',
        ],
        'features' => [
            'KI-Hintergrundentfernung im Browser',
            'Transparentes PNG, weißer oder beliebig farbiger Hintergrund',
            'Schneller Modus für jedes Gerät, Hohe Qualität mit WebGPU',
            'Kostenlos, ohne Anmeldung, ohne Wasserzeichen, ohne Upload',
        ],
        'content' => [
            [
                'heading' => 'Schnell oder Hohe Qualität: Was soll ich nutzen?',
                'body' => 'Der schnelle Modus nutzt ein kleines 4,4-MB-Modell, das auf jedem Handy und Computer läuft und klare Motive wie Produkte, Personen und Logos gut freistellt. Der Modus Hohe Qualität lädt einmalig ein 109-MB-Modell und liefert sauberere Kanten bei Haaren, Fell und feinen Details. Dafür ist ein Browser mit WebGPU nötig, zum Beispiel ein aktuelles Chrome oder Edge.',
            ],
            [
                'heading' => 'Wie gelingt die beste Freistellung?',
                'body' => 'Verwenden Sie ein Foto, auf dem das Motiv scharf ist und sich farblich oder in der Helligkeit vom Hintergrund abhebt. Unruhige Hintergründe, Bewegungsunschärfe und Motive, die mit dem Hintergrund verschwimmen, sind für jedes KI-Modell schwieriger. Wirkt eine Kante im schnellen Modus unsauber, probieren Sie Hohe Qualität.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Ist der Hintergrundentferner wirklich kostenlos?',
                'a' => 'Ja. Ohne Anmeldung, ohne Tageslimit und ohne Wasserzeichen – und Sie laden das Ergebnis in voller Größe herunter.',
            ],
            [
                'q' => 'Werden meine Fotos hochgeladen?',
                'a' => 'Nein. Das KI-Modell läuft in Ihrem Browser, Ihre Fotos bleiben also auf Ihrem Gerät. Nur die Modelldatei wird heruntergeladen und für das nächste Mal gespeichert.',
            ],
            [
                'q' => 'Welche Bildformate kann ich verwenden?',
                'a' => 'JPG, PNG, WebP und AVIF bis 50 MB. Das Ergebnis ist ein PNG mit transparentem Hintergrund oder in der Farbe Ihrer Wahl.',
            ],
            [
                'q' => 'Warum ist das erste Mal langsamer?',
                'a' => 'Beim ersten Mal lädt Ihr Browser das KI-Modell herunter (4,4 MB im schnellen Modus, 109 MB bei Hoher Qualität). Danach ist es gespeichert und startet deutlich schneller.',
            ],
        ],
    ],

    'broken-link-checker' => [
        'name' => 'Broken-Link-Checker',
        'title' => 'Broken-Link-Checker kostenlos: tote Links finden',
        'description' => 'Kostenloser Broken-Link-Checker: Finden Sie 404-Fehler, tote Links, defekte Bilder und Weiterleitungen auf jeder Webseite und exportieren Sie sie als CSV.',
        'h1' => 'Broken-Link-Checker',
        'tagline' => 'Finden Sie tote Links, 404-Fehler und Weiterleitungen auf jeder Seite.',
        'keywords' => [
            'broken link checker',
            'tote links finden',
            'defekte links prüfen',
            'link checker',
            '404 fehler finden',
            'kaputte links finden',
        ],
        'intro' => 'Ein Broken-Link-Checker findet Links auf einer Webseite, die nicht mehr funktionieren, etwa 404-Fehler („Seite nicht gefunden“), gelöschte Bilder oder abgelaufene Domains. Geben Sie eine Seitenadresse ein: Das Tool prüft jeden Link und jedes Bild (bis zu 300), zeigt, welche defekt sind, welche weiterleiten und welche funktionieren, und Sie können die Ergebnisse als CSV-Datei herunterladen.',
        'steps' => [
            'Geben Sie die Adresse der Seite ein, die Sie prüfen möchten, zum Beispiel example.com/blog.',
            'Klicken Sie auf Links prüfen; die Ergebnisse erscheinen, sobald jede Gruppe von Links getestet ist.',
            'Korrigieren oder entfernen Sie die defekten Links unter Probleme und aktualisieren Sie Links mit Weiterleitung.',
        ],
        'features' => [
            'Prüft alle Links und Bilder einer Seite (bis zu 300)',
            'Findet 404-Fehler, Serverfehler, tote Domains und Weiterleitungen',
            'Zeigt den Linktext und ob ein Link intern oder extern ist',
            'Kostenloser CSV-Export, ohne Anmeldung',
        ],
        'content' => [
            [
                'heading' => 'Warum sind defekte Links ein Problem?',
                'body' => 'Defekte Links schicken Besucher auf Fehlerseiten. Das ist ärgerlich und lässt eine Website vernachlässigt wirken. Suchmaschinen folgen außerdem Links, um Seiten zu finden – tote Links verschwenden ihr Crawling und können verhindern, dass wichtige Seiten entdeckt werden. Sie zu beheben ist einer der schnellsten Gewinne für SEO und Nutzererlebnis.',
            ],
            [
                'heading' => 'Was bedeuten die Ergebnisse?',
                'body' => 'OK heißt, der Link funktioniert. Weiterleitung heißt, er funktioniert, führt aber über eine oder mehrere Weiterleitungen; die Zieladresse direkt zu verlinken ist für Besucher schneller. Defekt heißt, die Seite antwortete mit einem Fehler wie 404 oder 500 oder die Domain existiert nicht mehr. Blockiert heißt, die Website lehnte die automatische Prüfung ab (Status 401, 403 oder 429) – öffnen Sie den Link selbst, um ihn zu prüfen.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Wie finde ich defekte Links auf meiner Website?',
                'a' => 'Geben Sie oben eine Seitenadresse ein und klicken Sie auf Links prüfen. Wiederholen Sie das für Ihre wichtigsten Seiten wie Startseite, Menüs und beliebte Artikel.',
            ],
            [
                'q' => 'Wird die ganze Website geprüft?',
                'a' => 'Geprüft werden alle Links und Bilder der eingegebenen Seite, bis zu 300. Für andere Seiten geben Sie deren Adressen einzeln ein.',
            ],
            [
                'q' => 'Warum sind manche Links als Blockiert markiert?',
                'a' => 'Manche Websites lehnen automatische Anfragen ab oder verlangen eine Anmeldung und antworten mit Status 401, 403 oder 429. Der Link kann in einem normalen Browser trotzdem funktionieren – öffnen Sie ihn zur Kontrolle.',
            ],
            [
                'q' => 'Werden die Seite oder meine Ergebnisse gespeichert?',
                'a' => 'Nein. Unser Server ruft die Seite und die Links nur zur Prüfung ab und speichert weder die Adresse noch die Ergebnisse.',
            ],
        ],
        'table' => [
            'caption' => 'Häufige HTTP-Statuscodes',
            'headers' => [
                'Code',
                'Bedeutung',
                'Was tun?',
            ],
            'rows' => [
                [
                    '200',
                    'OK',
                    'Nichts',
                ],
                [
                    '301 / 308',
                    'Dauerhaft verschoben',
                    'Link auf die neue Adresse ändern',
                ],
                [
                    '404',
                    'Seite nicht gefunden',
                    'Link korrigieren oder entfernen',
                ],
                [
                    '410',
                    'Endgültig entfernt',
                    'Link entfernen',
                ],
                [
                    '500 / 503',
                    'Serverfehler',
                    'Später erneut prüfen; Website-Betreiber informieren',
                ],
            ],
        ],
    ],

    'domain-authority-checker' => [
        'name' => 'Domain-Authority-Checker',
        'title' => 'Domain Authority Checker kostenlos - 100 auf einmal',
        'description' => 'Kostenloser Domain-Authority-Checker: Autoritätswert, globaler Rang und verweisende Domains von bis zu 100 Websites auf einmal – mit CSV-Export der Liste.',
        'h1' => 'Domain-Authority-Checker für viele Domains',
        'tagline' => 'Vergleichen Sie die Autorität von bis zu 100 Websites in Sekunden.',
        'keywords' => [
            'domain authority checker',
            'domain autorität prüfen',
            'domain authority prüfen',
            'da checker',
            'website autorität',
            'domain rating prüfen',
        ],
        'intro' => 'Ein Domain-Authority-Checker schätzt, wie stark eine Website in Suchmaschinen ist – danach, wie viele andere Websites auf sie verlinken und wie wichtig diese sind. Fügen Sie bis zu 100 Domains ein und sehen Sie für jede den OpenPageRank-Wert von 0 bis 10, den globalen Rang und die verweisenden Domains; sortieren Sie die Liste und laden Sie eine CSV herunter. Praktisch, um Mitbewerber zu vergleichen, Linkpartner zu prüfen und Websites für Gastbeiträge zu bewerten.',
        'steps' => [
            'Fügen Sie bis zu 100 Domains oder Seitenadressen ein, eine pro Zeile.',
            'Klicken Sie auf Autorität prüfen.',
            'Sortieren Sie die Ergebnisse nach Wert und laden Sie sie bei Bedarf als CSV herunter.',
        ],
        'features' => [
            'Bis zu 100 Domains in einer Prüfung',
            'Autoritätswert von 0 bis 10, globaler Rang und verweisende Domains',
            'Akzeptiert vollständige URLs und entfernt www automatisch',
            'Kostenloser CSV-Export, ohne Anmeldung',
        ],
        'content' => [
            [
                'heading' => 'Ist das dasselbe wie Moz Domain Authority?',
                'body' => 'Nein. Domain Authority (DA) ist ein Wert von 0 bis 100 der Firma Moz, Domain Rating (DR) gehört zu Ahrefs. Dieses Tool zeigt OpenPageRank, einen Wert von 0 bis 10, der mit dem PageRank-Verfahren aus dem öffentlichen Web-Graphen von Common Crawl berechnet wird. Alle messen dieselbe Idee – die Stärke der Links einer Website –, werden aber unterschiedlich berechnet, daher lassen sich die Zahlen nicht ineinander umrechnen.',
            ],
            [
                'heading' => 'Was ist ein guter Wert?',
                'body' => 'Die Skala ist logarithmisch: Von 2 auf 3 braucht es viel weniger Links als von 8 auf 9. Neue Websites starten meist nahe 0, kleine etablierte Websites liegen oft bei 2 bis 4, bekannte Marken bei 5 bis 7, und nur die größten Websites im Internet erreichen 9 oder 10. Vergleichen Sie eine Website mit anderen aus derselben Branche statt mit den Riesen.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Wie prüfe ich die Domain Authority einer Website?',
                'a' => 'Fügen Sie die Domain in das Feld ein und klicken Sie auf Autorität prüfen. Sie können bis zu 100 Domains auf einmal prüfen.',
            ],
            [
                'q' => 'Woher stammen die Werte?',
                'a' => 'Von OpenPageRank, das die Autorität aus dem Web-Graphen von Common Crawl berechnet, einem öffentlichen Crawl von Milliarden Webseiten. Die Werte werden monatlich aktualisiert.',
            ],
            [
                'q' => 'Wie kann ich meinen Wert verbessern?',
                'a' => 'Gewinnen Sie Links von angesehenen Websites Ihrer Branche: hilfreiche Inhalte, gute Verzeichnisse, Gastbeiträge und Erwähnungen in der Presse. Links von vielen verschiedenen Websites zählen mehr als viele Links von einer einzigen.',
            ],
            [
                'q' => 'Warum steht bei einer Website Nicht gefunden?',
                'a' => 'Sehr neue oder sehr kleine Websites haben im Web-Graphen eventuell noch nicht genug Links, um einen Wert zu erhalten.',
            ],
        ],
        'table' => [
            'caption' => 'Autoritätswerte im Vergleich',
            'headers' => [
                'Kennzahl',
                'Anbieter',
                'Skala',
            ],
            'rows' => [
                [
                    'OpenPageRank',
                    'OpenPageRank (Daten von Common Crawl)',
                    '0-10',
                ],
                [
                    'Domain Authority (DA)',
                    'Moz',
                    '0-100',
                ],
                [
                    'Domain Rating (DR)',
                    'Ahrefs',
                    '0-100',
                ],
                [
                    'Authority Score',
                    'Semrush',
                    '0-100',
                ],
            ],
        ],
    ],

    'domain-age-checker' => [
        'name' => 'Domainalter-Prüfung',
        'title' => 'Domainalter prüfen: Wann wurde die Domain registriert?',
        'description' => 'Kostenlose Domainalter-Prüfung: Alter, Ablaufdatum, Registrar und Nameserver von bis zu 20 Domains, mit Daten von RDAP, dem Nachfolger von WHOIS.',
        'h1' => 'Domainalter prüfen',
        'tagline' => 'Sieh das genaue Alter, Ablaufdatum und den Registrar von bis zu 20 Domains.',
        'keywords' => [
            'domainalter prüfen',
            'alter einer domain',
            'wann wurde eine domain registriert',
            'domain-registrierungsdatum',
            'domain-abfrage',
            'rdap abfrage',
        ],
        'intro' => 'Eine Domainalter-Prüfung fragt den offiziellen Registrierungseintrag eines Domainnamens ab, um genau zu zeigen, wie alt er ist. Gib bis zu 20 Domains ein, um für jede das Erstellungsdatum, das genaue Alter in Jahren, Monaten und Tagen, das Ablaufdatum, die letzte Aktualisierung, den Registrar und die Nameserver zu sehen – live von RDAP, dem kostenlosen, schlüssellosen Nachfolger von WHOIS. Das ist nützlich, um eine Website vor dem Kauf oder einer Verlinkung zu recherchieren, zu prüfen, wie lange ein Unternehmen schon online ist, und die Verlängerungstermine der eigenen Domains im Blick zu behalten.',
        'steps' => [
            'Gib bis zu 20 Domains oder Seitenadressen ein, eine pro Zeile.',
            'Klicke auf Domainalter prüfen.',
            'Sieh dir Alter, Daten, Registrar und Nameserver jeder Domain an oder lade die Ergebnisse als CSV herunter.',
        ],
        'features' => [
            'Bis zu 20 Domains in einer Prüfung',
            'Genaues Alter in Jahren, Monaten und Tagen sowie Erstellungs-, Ablauf- und letztes Aktualisierungsdatum',
            'Registrar, Statuscodes und Nameserver für jede Domain',
            'Live-Daten direkt von RDAP, keine Anmeldung, kostenloser CSV-Export',
        ],
        'content' => [
            [
                'heading' => 'Was ist RDAP und wie unterscheidet es sich von WHOIS?',
                'body' => 'RDAP (Registration Data Access Protocol) ist der moderne, standardisierte Nachfolger von WHOIS. Während WHOIS einfachen Text zurückgibt, dessen Format je nach Registry unterschiedlich ist, liefert RDAP strukturiertes JSON mit überall gleichen Feldnamen, ist kostenlos und schlüssellos abrufbar und unterstützt internationalisierte Domainnamen sowie präzise Zugriffskontrollen. ICANN verpflichtete alle akkreditierten Registrare und gTLD-Registries zum Betrieb von RDAP-Diensten, und auch Länder-Registries wie die deutsche DENIC oder die polnische NASK haben RDAP ergänzt – WHOIS wird deshalb zunehmend durch RDAP abgelöst.',
            ],
            [
                'heading' => 'Warum zeigen manche Domains „nicht unterstützt“ oder „kein Eintrag gefunden“ an?',
                'body' => 'Eine kleine Zahl von Länder-Domainendungen hat noch keinen RDAP-Dienst eingeführt, sodass für sie keine Registry erreichbar ist; diese zeigen „nicht unterstützt“. Eine Domain kann auch keinen Eintrag zeigen, wenn sie aktuell nicht registriert ist, erst sehr kürzlich registriert wurde und noch nicht in den öffentlichen Daten der Registry erscheint, oder wenn die Registry vorübergehend nicht erreichbar ist. Nichts davon bedeutet, dass die Prüfung falsch liegt: Die angezeigten Daten stammen immer direkt aus der Live-Antwort der jeweiligen Registry, niemals aus einer Schätzung.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Wie kann ich prüfen, wie alt eine Domain ist?',
                'a' => 'Gib die Domain oben ein und klicke auf Domainalter prüfen. Das genaue Registrierungsdatum und das Alter in Jahren, Monaten und Tagen stammen direkt aus dem RDAP-Eintrag der Domain.',
            ],
            [
                'q' => 'Sind das dieselben Informationen wie bei einer WHOIS-Abfrage?',
                'a' => 'Ja, es sind dieselben Registrierungsdaten, nur über RDAP abgerufen, das strukturierte, schlüssellose Protokoll, das WHOIS ablöst. Datum, Registrar und Nameserver stammen in beiden Fällen aus demselben Registry-Eintrag.',
            ],
            [
                'q' => 'Warum ist das Ablaufdatum wichtig?',
                'a' => 'Eine Domain, die nicht vor ihrem Ablaufdatum verlängert wird, kann in eine Nachfrist eintreten und anschließend für jeden zur Registrierung freigegeben werden. Das Ablaufdatum einer Website zu prüfen, ist eine schnelle Möglichkeit zu beurteilen, wie aktiv sie gepflegt wird.',
            ],
            [
                'q' => 'Kann ich jede Domainendung prüfen?',
                'a' => 'Die meisten gängigen Endungen (darunter .com, .net, .org, .io, .co.uk, .de und .pl) haben RDAP-Einträge. Eine kleine Zahl kleinerer Länderendungen hat RDAP noch nicht eingeführt; diese werden als nicht unterstützt angezeigt, statt geraten zu werden.',
            ],
        ],
        'table' => [
            'caption' => 'Angezeigte RDAP-Ereignistypen',
            'headers' => ['Feld', 'RDAP-Ereignis', 'Bedeutung'],
            'rows' => [
                ['Erstellt', 'registration', 'Wann die Domain erstmals registriert wurde'],
                ['Läuft ab', 'expiration', 'Wann der aktuelle Registrierungszeitraum endet'],
                ['Zuletzt aktualisiert', 'last changed', 'Wann der Registry-Eintrag selbst zuletzt geändert wurde'],
            ],
        ],
    ],
    'rotate-pdf' => [
        'name' => 'PDF drehen',
        'title' => 'PDF Drehen - Schiefe Seiten Kostenlos Korrigieren',
        'description' => 'Drehen Sie PDF-Seiten kostenlos um 90, 180 oder 270 Grad - das ganze Dokument oder nur ausgewählte Seiten. Kein Upload, kein Wasserzeichen, keine Anmeldung.',
        'h1' => 'PDF drehen',
        'tagline' => 'Schiefe oder auf dem Kopf stehende Seiten direkt im Browser richtig ausrichten.',
        'keywords' => ['pdf drehen', 'pdf seiten drehen', 'pdf online drehen', 'pdf seite drehen', 'schiefe pdf korrigieren'],
        'intro' => 'Eine gescannte Seite oder ein Foto in der falschen Ausrichtung landet in einem PDF oft schief oder auf dem Kopf stehend. Dieses Werkzeug zum PDF drehen dreht Seiten um 90, 180 oder 270 Grad, damit sie richtig herum zu lesen sind. Drehen Sie das gesamte Dokument auf einmal oder nur die Seiten, die es brauchen, und laden Sie dann die korrigierte Datei herunter. Alles geschieht auf Ihrem Gerät - Ihr PDF wird nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF aus, das Sie korrigieren möchten.',
            'Klicken Sie auf eine Seite, um sie auszuwählen, oder wählen Sie keine aus, um das ganze Dokument zu drehen.',
            'Klicken Sie auf 90°, 90° oder 180°, um die ausgewählten Seiten (oder alle) zu drehen.',
            'Klicken Sie auf PDF drehen und laden Sie die korrigierte Datei herunter.',
        ],
        'features' => [
            'Drehung um 90, 180 oder 270 Grad',
            'Das ganze Dokument oder nur ausgewählte Seiten drehen',
            'Miniaturansichten zeigen das Ergebnis vor dem Herunterladen',
            'Kein Wasserzeichen und kein Qualitätsverlust',
            'Privat - Ihr PDF verlässt niemals Ihr Gerät',
        ],
        'content' => [
            ['heading' => 'Warum landen PDF-Seiten schief?', 'body' => 'Scanner und Handykameras speichern manche Seite im Querformat in einem sonst hochformatigen Dokument, wodurch diese Seite beim Lesen des PDFs schief erscheint. Nur diese Seite statt der ganzen Datei zu drehen, behebt das Problem, ohne den Rest des Dokuments zu verändern.'],
            ['heading' => 'Verändert das Drehen den Seiteninhalt?', 'body' => 'Nein. Das Drehen ändert nur die Ausrichtungskennung der Seite, die jeder PDF-Betrachter und Drucker zur korrekten Anzeige verwendet. Text, Bilder und Qualität der Seite selbst bleiben unberührt.'],
        ],
        'faqs' => [
            ['q' => 'Kann ich nur eine Seite statt des ganzen PDFs drehen?', 'a' => 'Ja. Klicken Sie auf die Miniaturansicht der Seite (oder Seiten), die Sie korrigieren möchten, bevor Sie auf einen Drehen-Button klicken; nur die ausgewählten Seiten drehen sich. Wählen Sie keine aus, um alle zu drehen.'],
            ['q' => 'Welche Drehwinkel sind verfügbar?', 'a' => 'Drehen Sie um 90 Grad nach links oder rechts, oder wenden Sie eine Seite um 180 Grad, wenn sie auf dem Kopf stehend gescannt wurde. Sie können mehrere Klicks kombinieren, um jede der vier Ausrichtungen zu erreichen.'],
            ['q' => 'Wird mein PDF auf einen Server hochgeladen?', 'a' => 'Nein. Das PDF wird vollständig in Ihrem Browser mit JavaScript geöffnet und gedreht und nie irgendwohin gesendet.'],
            ['q' => 'Fügt das ein Wasserzeichen hinzu oder verringert die Qualität?', 'a' => 'Nein. Das Drehen ändert nur die Ausrichtung jeder Seite. Es wird kein Wasserzeichen, Logo oder zusätzliche Seite hinzugefügt, und es geht keine Bild- oder Textqualität verloren.'],
        ],
    ],    'delete-pdf-pages' => [
        'name' => 'PDF-Seiten löschen',
        'title' => 'PDF-Seiten Löschen - Seiten Kostenlos Entfernen',
        'description' => 'Löschen Sie PDF-Seiten kostenlos online - per Miniaturansicht oder Bereich wie 2, 4-6. Kein Upload, kein Wasserzeichen, keine Anmeldung.',
        'h1' => 'PDF-Seiten löschen',
        'tagline' => 'Entfernen Sie die Seiten, die Sie nicht brauchen, direkt im Browser.',
        'keywords' => ['pdf seiten löschen', 'pdf seite entfernen', 'seiten aus pdf löschen', 'pdf seiten entfernen online', 'pdf seite löschen'],
        'intro' => 'Ein leeres Deckblatt, ein doppelter Scan oder eine unnötige Seite lassen sich aus einem PDF entfernen, ohne die ganze Datei neu zu erstellen. Dieses Werkzeug löscht Seiten aus einem PDF per Klick auf die Miniaturansicht oder durch Eingabe von Bereichen wie 2, 4-6, und speichert dann eine neue Datei nur mit den Seiten, die Sie behalten möchten. Alles geschieht auf Ihrem Gerät, das PDF wird also nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF aus, das Sie bearbeiten möchten.',
            'Klicken Sie auf die Miniaturansicht jeder zu löschenden Seite, oder wechseln Sie zu Seitenbereichen und geben Sie Zahlen wie 2, 4-6 ein.',
            'Prüfen Sie die zum Löschen markierten Seiten im Raster.',
            'Klicken Sie auf Seiten löschen und laden Sie das neue PDF herunter.',
        ],
        'features' => [
            'Seiten per Miniaturansicht oder durch Eingabe von Bereichen wählen',
            'Miniaturansichten zeigen genau, was Sie entfernen',
            'Es bleibt immer mindestens eine Seite übrig - nicht alles kann versehentlich gelöscht werden',
            'Kein Wasserzeichen und kein Qualitätsverlust bei den verbleibenden Seiten',
            'Privat - Ihr PDF verlässt niemals Ihr Gerät',
        ],
        'content' => [
            ['heading' => 'Wann Seiten löschen statt teilen', 'body' => 'Nutzen Sie dieses Werkzeug, wenn der größte Teil eines PDFs in Ordnung ist und nur wenige Seiten weg müssen, etwa eine leere Seite, ein Duplikat oder ein veraltetes Deckblatt. Wenn Sie stattdessen bestimmte Seiten in eine eigene Datei herauslösen möchten, erledigt das der Modus „Seiten extrahieren" von PDF teilen.'],
            ['heading' => 'Kann eine gelöschte Seite zurückgeholt werden?', 'body' => 'Nicht aus der neuen Datei - einmal herunterladen, sind die entfernten Seiten aus dieser Kopie weg. Bewahren Sie Ihr Original-PDF auf, bis Sie sicher sind, dass das Ergebnis stimmt, denn hier wird nie die Datei auf Ihrem Gerät überschrieben.'],
        ],
        'faqs' => [
            ['q' => 'Wie lösche ich mehrere Seiten gleichzeitig?', 'a' => 'Klicken Sie auf die Miniaturansicht jeder Seite, um sie zu markieren, oder wechseln Sie zu „Seitenbereiche" und geben Sie etwas wie 2, 4-6 ein, um mehrere auf einmal zu markieren.'],
            ['q' => 'Kann ich alle Seiten im PDF löschen?', 'a' => 'Nein. Mindestens eine Seite muss übrig bleiben, daher bleibt die Schaltfläche Seiten löschen deaktiviert, wenn Ihre Auswahl alle entfernen würde.'],
            ['q' => 'Wird mein PDF irgendwohin hochgeladen?', 'a' => 'Nein. Die Seiten werden vollständig in Ihrem Browser mit JavaScript entfernt, und die Datei wird nie an einen Server gesendet.'],
            ['q' => 'Verlieren die verbleibenden Seiten an Qualität?', 'a' => 'Nein. Die behaltenen Seiten werden exakt so kopiert, wie sie sind, ohne erneute Komprimierung, Wasserzeichen oder zusätzliche Seiten.'],
        ],
    ],    'organize-pdf' => [
        'name' => 'PDF organisieren',
        'title' => 'PDF Organisieren - Seiten Kostenlos Neu Anordnen',
        'description' => 'Ordnen Sie die Seiten eines PDFs kostenlos online neu an. Ziehen Sie Miniaturansichten in eine neue Reihenfolge, oder nutzen Sie die Verschieben-Buttons.',
        'h1' => 'PDF organisieren',
        'tagline' => 'Ziehen Sie Seiten in die gewünschte Reihenfolge, direkt im Browser.',
        'keywords' => ['pdf organisieren', 'pdf seiten neu anordnen', 'pdf reihenfolge ändern', 'pdf seiten sortieren', 'pdf seiten umsortieren'],
        'intro' => 'Seiten landen nach dem Scannen oder dem Zusammenführen mehrerer Dokumente manchmal in der falschen Reihenfolge. Dieses Werkzeug organisiert ein PDF, indem Sie Seiten-Miniaturansichten in eine neue Reihenfolge ziehen oder sie mit den Pfeil-Buttons verschieben, wenn Sie nicht ziehen möchten. Sobald die Reihenfolge stimmt, speichern Sie ein neues PDF mit den neu angeordneten Seiten. Alles geschieht auf Ihrem Gerät, die Datei wird also nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF aus, das Sie neu anordnen möchten.',
            'Ziehen Sie die Miniaturansicht einer Seite an ihre neue Position, oder nutzen Sie die Buttons ← und →.',
            'Wiederholen Sie dies, bis die Seiten in der gewünschten Reihenfolge sind.',
            'Klicken Sie auf Neue Reihenfolge speichern und laden Sie das neu geordnete PDF herunter.',
        ],
        'features' => [
            'Miniaturansichten per Ziehen neu anordnen',
            'Verschieben-Buttons funktionieren auch ohne Maus, für Tastaturnutzer',
            'Seitenzahlen aktualisieren sich live während des Anordnens',
            'Kein Wasserzeichen und kein Qualitätsverlust',
            'Privat - Ihr PDF verlässt niemals Ihr Gerät',
        ],
        'content' => [
            ['heading' => 'Wann Seiten neu angeordnet werden müssen', 'body' => 'Ein häufiger Fall ist das Scannen eines Papierstapels, der in der falschen Reihenfolge herauskommt, oder das Zusammenführen zweier PDFs, bei denen eines mitten im anderen eingefügt werden muss. Statt neu anzufangen, lässt dieses Werkzeug Sie die Reihenfolge eines vorhandenen PDFs direkt korrigieren.'],
            ['heading' => 'Neu anordnen ohne Maus', 'body' => 'Jede Seiten-Miniaturansicht hat Buttons „nach vorne verschieben" und „nach hinten verschieben", sodass Seiten per Tastatur oder Touchscreen genauso leicht neu angeordnet werden können wie durch Ziehen.'],
        ],
        'faqs' => [
            ['q' => 'Kann ich Seiten ohne Ziehen neu anordnen?', 'a' => 'Ja. Jede Miniaturansicht hat Buttons ← und →, die sie um eine Position nach vorne oder hinten verschieben, und diese funktionieren auch per Tastatur.'],
            ['q' => 'Ändert das Neuanordnen den Inhalt einer Seite?', 'a' => 'Nein. Seiten werden exakt so kopiert, wie sie sind; nur ihre Position im Dokument ändert sich.'],
            ['q' => 'Wird mein PDF auf einen Server hochgeladen?', 'a' => 'Nein. Das PDF wird vollständig in Ihrem Browser mit JavaScript geöffnet und neu angeordnet und nie irgendwohin gesendet.'],
            ['q' => 'Kann ich hier auch Seiten löschen oder drehen?', 'a' => 'Dieses Werkzeug ordnet nur Seiten neu an. Nutzen Sie dafür PDF-Seiten löschen oder PDF drehen, vor oder nach dem Organisieren der Reihenfolge.'],
        ],
    ],    'pdf-to-jpg' => [
        'name' => 'PDF zu JPG',
        'title' => 'PDF zu JPG Konverter - Seiten Kostenlos Umwandeln',
        'description' => 'Wandeln Sie PDF-Seiten kostenlos in JPG-Bilder um. Wählen Sie 72, 150 oder 300 DPI und laden Sie ein Bild oder ein ZIP herunter. Kein Upload, keine Anmeldung.',
        'h1' => 'PDF zu JPG',
        'tagline' => 'Verwandeln Sie PDF-Seiten in JPG-Bilder, direkt im Browser.',
        'keywords' => ['pdf zu jpg', 'pdf jpg konverter', 'pdf in jpg umwandeln', 'pdf zu bild', 'pdf seite zu jpg'],
        'intro' => 'Ein PDF-zu-JPG-Konverter wandelt jede Seite eines PDFs in ein JPG-Bild um - nützlich, um eine Seite in sozialen Netzwerken zu teilen, in ein Dokument einzufügen oder anzusehen, wo PDFs nicht unterstützt werden. Wählen Sie eine Auflösung von 72, 150 oder 300 DPI und wandeln Sie um: Ein einseitiges PDF wird als ein JPG heruntergeladen, ein mehrseitiges PDF als ZIP mit durchnummerierten Bildern. Alles geschieht auf Ihrem Gerät, das PDF wird also nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF aus, das Sie umwandeln möchten.',
            'Wählen Sie eine Bildqualität: 72 DPI für Bildschirme, 150 für allgemeine Zwecke oder 300 DPI zum Drucken.',
            'Klicken Sie auf Umwandeln.',
            'Laden Sie das JPG herunter, oder die ZIP-Datei, wenn das PDF mehr als eine Seite hat.',
        ],
        'features' => [
            'Wählen Sie 72, 150 oder 300 DPI',
            'Einseitige PDFs werden als ein einzelnes JPG heruntergeladen',
            'Mehrseitige PDFs werden als ZIP mit durchnummerierten Bildern heruntergeladen',
            'Seiten-Miniaturansichten bestätigen die richtige Datei',
            'Privat - Ihr PDF verlässt niemals Ihr Gerät',
        ],
        'content' => [
            ['heading' => 'Welche DPI soll ich wählen?', 'body' => '72 DPI entspricht einem typischen Bildschirm und ergibt die kleinste Datei, gut für schnelle Vorschauen oder Webnutzung. 150 DPI ist eine gute Allzweckwahl zum Teilen oder Einfügen in Dokumente. 300 DPI erzeugt ein schärferes, größeres Bild, geeignet zum Drucken oder zum Vergrößern feinen Texts.'],
            ['heading' => 'PDF zu JPG oder PDF zu PNG', 'body' => 'JPG nutzt verlustbehaftete Kompression, was kleinere Dateien ergibt und sich für gescannte Seiten oder Fotos eignet. PNG ist verlustfrei und besser für Seiten mit scharfem Text, Tabellen oder Strichzeichnungen, auf Kosten einer größeren Datei. Nutzen Sie PDF zu PNG, wenn Bildqualität wichtiger ist als Dateigröße.'],
        ],
        'faqs' => [
            ['q' => 'Kann ich alle Seiten eines PDFs auf einmal zu JPG umwandeln?', 'a' => 'Ja. Beim Umwandeln werden alle Seiten verarbeitet; bei mehr als einer Seite werden die Bilder für den Download in einer einzigen ZIP-Datei gebündelt.'],
            ['q' => 'Welche DPI sollte ich zum Drucken verwenden?', 'a' => '300 DPI ergibt ein scharfes Ergebnis zum Drucken. 150 DPI reicht für die meisten Bildschirme, und 72 DPI ist die kleinste Datei, am besten für schnelle Vorschauen.'],
            ['q' => 'Wird mein PDF auf einen Server hochgeladen?', 'a' => 'Nein. Seiten werden vollständig in Ihrem Browser mit JavaScript in Bilder umgewandelt, und die Datei wird nie irgendwohin gesendet.'],
            ['q' => 'Kann ich nur eine Seite statt des ganzen PDFs umwandeln?', 'a' => 'Dieses Werkzeug wandelt alle Seiten um. Für nur eine Seite nutzen Sie zuerst den Modus „Seiten extrahieren" von PDF teilen und wandeln dann das entstandene einseitige PDF hier um.'],
        ],
    ],
    'pdf-to-png' => [
        'name' => 'PDF zu PNG',
        'title' => 'PDF zu PNG Konverter - Seiten Kostenlos Umwandeln',
        'description' => 'Wandeln Sie PDF-Seiten kostenlos in PNG-Bilder um. Wählen Sie 72, 150 oder 300 DPI und laden Sie ein Bild oder ein ZIP herunter. Kein Upload, keine Anmeldung.',
        'h1' => 'PDF zu PNG',
        'tagline' => 'Verwandeln Sie PDF-Seiten in scharfe PNG-Bilder, direkt im Browser.',
        'keywords' => ['pdf zu png', 'pdf png konverter', 'pdf in png umwandeln', 'pdf seite zu png', 'pdf zu bild png'],
        'intro' => 'Ein PDF-zu-PNG-Konverter wandelt jede Seite eines PDFs in ein verlustfreies PNG-Bild um, das scharfen Text, Tabellen und Strichzeichnungen erhält. Wählen Sie eine Auflösung von 72, 150 oder 300 DPI und wandeln Sie um: Ein einseitiges PDF wird als ein PNG heruntergeladen, ein mehrseitiges PDF als ZIP mit durchnummerierten Bildern. Alles geschieht auf Ihrem Gerät, das PDF wird also nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF aus, das Sie umwandeln möchten.',
            'Wählen Sie eine Bildqualität: 72 DPI für Bildschirme, 150 für allgemeine Zwecke oder 300 DPI zum Drucken.',
            'Klicken Sie auf Umwandeln.',
            'Laden Sie das PNG herunter, oder die ZIP-Datei, wenn das PDF mehr als eine Seite hat.',
        ],
        'features' => [
            'Wählen Sie 72, 150 oder 300 DPI',
            'Verlustfreie PNG-Ausgabe, scharf für Text und Strichzeichnungen',
            'Einseitige PDFs werden als ein einzelnes PNG heruntergeladen',
            'Mehrseitige PDFs werden als ZIP mit durchnummerierten Bildern heruntergeladen',
            'Privat - Ihr PDF verlässt niemals Ihr Gerät',
        ],
        'content' => [
            ['heading' => 'Welche DPI soll ich wählen?', 'body' => '72 DPI entspricht einem typischen Bildschirm und ergibt die kleinste Datei, gut für schnelle Vorschauen oder Webnutzung. 150 DPI ist eine gute Allzweckwahl zum Teilen oder Einfügen in Dokumente. 300 DPI erzeugt ein schärferes, größeres Bild, geeignet zum Drucken oder zum Vergrößern feinen Texts.'],
            ['heading' => 'PDF zu PNG oder PDF zu JPG', 'body' => 'PNG ist verlustfrei, wodurch scharfer Text, Tabellen und Strichzeichnungen klar bleiben, auf Kosten einer größeren Datei. JPG nutzt verlustbehaftete Kompression für kleinere Dateien und eignet sich für gescannte Seiten oder Fotos. Nutzen Sie PDF zu JPG, wenn die Dateigröße wichtiger ist als exakte Pixelqualität.'],
        ],
        'faqs' => [
            ['q' => 'Warum PNG statt JPG wählen?', 'a' => 'PNG ist verlustfrei, sodass scharfer Text, Tabellen und Diagramme ohne Kompressionsartefakte klar bleiben. JPG-Dateien sind meist kleiner, können aber feine Details verwischen.'],
            ['q' => 'Kann ich alle Seiten eines PDFs auf einmal zu PNG umwandeln?', 'a' => 'Ja. Beim Umwandeln werden alle Seiten verarbeitet; bei mehr als einer Seite werden die Bilder für den Download in einer einzigen ZIP-Datei gebündelt.'],
            ['q' => 'Wird mein PDF auf einen Server hochgeladen?', 'a' => 'Nein. Seiten werden vollständig in Ihrem Browser mit JavaScript in Bilder umgewandelt, und die Datei wird nie irgendwohin gesendet.'],
            ['q' => 'Welche DPI sollte ich zum Drucken verwenden?', 'a' => '300 DPI ergibt ein scharfes Ergebnis zum Drucken. 150 DPI reicht für die meisten Bildschirme, und 72 DPI ist die kleinste Datei, am besten für schnelle Vorschauen.'],
        ],
    ],

    'compress-pdf' => [
        'name' => 'PDF komprimieren',
        'title' => 'PDF komprimieren - Dateigröße kostenlos reduzieren',
        'description' => 'Komprimieren Sie ein PDF online kostenlos, um es kleiner zu machen. Modus „Empfohlen" hält Text auswählbar; „Stark" verkleinert stärker. Kein Upload.',
        'h1' => 'PDF komprimieren',
        'tagline' => 'Machen Sie ein PDF kleiner, ohne die Lesbarkeit zu verlieren - direkt in Ihrem Browser.',
        'keywords' => [
            'pdf komprimieren',
            'pdf compressor',
            'pdf größe reduzieren',
            'pdf verkleinern',
            'pdf komprimieren online',
        ],
        'intro' => 'Ein Tool zum PDF komprimieren verkleinert eine PDF-Datei, indem es die darin enthaltenen Bilder reduziert, damit sie sich leichter per E-Mail versenden, hochladen oder speichern lässt. Der Modus „Empfohlen" komprimiert eingebettete Fotos mit geringerer Qualität neu, während der Text scharf und auswählbar bleibt. Der Modus „Stark" geht weiter und verwandelt jede Seite in ein einziges Bild, was die kleinstmögliche Datei ergibt, aber bedeutet, dass Text nicht mehr ausgewählt oder durchsucht werden kann. Alles läuft auf Ihrem Gerät ab, Ihr PDF wird also nie hochgeladen.',
        'steps' => [
            'Wählen Sie das PDF, das Sie komprimieren möchten.',
            'Wählen Sie „Empfohlen", um Bilder zu verkleinern und den Text auswählbar zu halten, oder „Stark" für die kleinstmögliche Datei.',
            'Wählen Sie im Modus „Stark" eine Bildqualität (DPI).',
            'Klicken Sie auf PDF komprimieren und laden Sie die kleinere Datei herunter.',
        ],
        'features' => [
            'Der Modus „Empfohlen" hält Text auswählbar und durchsuchbar',
            'Der Modus „Stark" liefert die kleinste Datei, indem er Seiten in Bilder umwandelt',
            'Zeigt die Größe vorher und nachher, damit Sie die Ersparnis sehen',
            'Behält die Originaldatei, wenn eine Komprimierung sie nicht verkleinern würde',
            'Privat - Ihr PDF verlässt nie Ihr Gerät',
        ],
        'content' => [
            [
                'heading' => '„Empfohlen" oder „Stark" - was ist die richtige Wahl?',
                'body' => 'Der Modus „Empfohlen" komprimiert nur die Fotos und gescannten Bilder im PDF neu, sodass Überschriften, Absätze und Tabellen genau gleich bleiben und weiterhin ausgewählt, durchsucht und kopiert werden können. Der Modus „Stark" wandelt jede Seite in ein einziges JPEG-Bild um, was meist eine viel kleinere Datei ergibt, aber bedeutet, dass danach kein Text mehr ausgewählt, durchsucht oder kopiert werden kann - besser geeignet für fotolastige Dokumente, die zum Teilen einfach nur kleiner sein müssen.',
            ],
            [
                'heading' => 'Warum ist mein PDF nicht kleiner geworden?',
                'body' => 'Ein PDF, das nur aus Text und Vektorgrafiken besteht, oder eines, das bereits komprimiert wurde, schrumpft im Modus „Empfohlen" möglicherweise nicht weiter, weil keine großen Bilder mehr zum Neukomprimieren übrig sind. In diesem Fall wird die Originaldatei beibehalten, damit Sie nie mit einem größeren Download enden, und der Modus „Stark" kann sie trotzdem verkleinern, indem er die Seiten in Bilder umwandelt.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Verringert das Komprimieren eines PDFs die Qualität?',
                'a' => 'Der Modus „Empfohlen" senkt die Qualität eingebetteter Fotos leicht, ähnlich wie das Speichern eines JPEGs mit einer niedrigeren Einstellung, während Text und Strichgrafiken scharf bleiben. Der Modus „Stark" rendert die gesamte Seite als Bild, sodass sehr kleiner Text beim Hineinzoomen weniger scharf wirken kann.',
            ],
            [
                'q' => 'Kann ich nach dem Komprimieren noch Text auswählen?',
                'a' => 'Ja, mit dem Modus „Empfohlen". Der Modus „Stark" rastert jede Seite zu einem einzigen Bild, sodass Text danach nicht mehr ausgewählt, durchsucht oder kopiert werden kann - wählen Sie ihn nur, wenn die Dateigröße wichtiger ist als das.',
            ],
            [
                'q' => 'Was passiert, wenn die komprimierte Datei nicht kleiner ist?',
                'a' => 'Die Originaldatei wird beibehalten und unverändert zum Download angeboten, sodass Sie nie mit einem größeren Ergebnis als zu Beginn enden.',
            ],
            [
                'q' => 'Wird mein PDF an einen Server gesendet?',
                'a' => 'Nein. Die Komprimierung erfolgt vollständig in Ihrem Browser mit JavaScript, und die Datei wird nie irgendwohin gesendet.',
            ],
        ],
    ],

    'protect-pdf' => [
        'name' => 'PDF schützen',
        'title' => 'PDF schützen - Passwort kostenlos hinzufügen',
        'description' => 'Fügen Sie einem PDF online kostenlos ein echtes Passwort mit AES-256-Verschlüsselung hinzu. Nur wer es kennt, kann die Datei öffnen. Kein Upload.',
        'h1' => 'PDF schützen',
        'tagline' => 'Sperren Sie ein PDF mit einem Passwort, damit es nur jemand öffnen kann, der es kennt.',
        'keywords' => [
            'pdf schützen',
            'pdf passwort schützen',
            'pdf passwort hinzufügen',
            'pdf verschlüsseln',
            'pdf passwort online',
        ],
        'intro' => 'Ein PDF zu schützen fügt ein Passwort hinzu, sodass die Datei nur von jemandem geöffnet werden kann, der es kennt. Dieses Tool verschlüsselt Ihr PDF direkt in Ihrem Browser mit echter AES-256-Verschlüsselung, derselben Stärke, die auch Banken und Behörden verwenden. Wählen Sie ein Passwort, bestätigen Sie es, und laden Sie eine Kopie des PDFs herunter, die dieses Passwort verlangt, bevor es sich in einem beliebigen PDF-Reader öffnen lässt.',
        'steps' => [
            'Wählen Sie das PDF, das Sie schützen möchten.',
            'Geben Sie ein Passwort ein und bestätigen Sie es.',
            'Klicken Sie auf PDF schützen.',
            'Laden Sie die passwortgeschützte Kopie herunter.',
        ],
        'features' => [
            'Echte AES-256-Verschlüsselung, kein bloßer Dateinamen-Trick',
            'Öffnet sich nur mit dem von Ihnen festgelegten Passwort',
            'Funktioniert mit jedem PDF-Reader, der die PDF-Standardverschlüsselung unterstützt',
            'Vollständig in Ihrem Browser verarbeitet - das PDF wird nie hochgeladen',
            'Kein Wasserzeichen, kein Seitenlimit',
        ],
        'content' => [
            [
                'heading' => 'Wie stark ist die Verschlüsselung?',
                'body' => 'Das PDF wird mit AES-256 verschlüsselt, demselben Algorithmus, der häufig zum Schutz sensibler Daten verwendet wird, mithilfe der Open-Source-Bibliothek QPDF, die als WebAssembly in Ihrem Browser läuft. Ohne das Passwort kann der Inhalt der Datei von keinem PDF-Betrachter gelesen werden.',
            ],
            [
                'heading' => 'Was, wenn ich das Passwort vergesse?',
                'body' => 'Ein vergessenes Passwort eines mit AES-256 geschützten PDFs lässt sich absichtlich nicht wiederherstellen - genau das macht den Schutz wirksam. Bewahren Sie eine Kopie des Passworts an einem sicheren Ort auf, etwa in einem Passwort-Manager, und behalten Sie die ungeschützte Originaldatei, bis Sie sicher sind, dass Sie sich daran erinnern werden.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Wird mein PDF dabei irgendwohin hochgeladen?',
                'a' => 'Nein. Die Datei wird vollständig in Ihrem Browser mit JavaScript verschlüsselt, mithilfe einer als WebAssembly kompilierten Version von QPDF, und verlässt nie Ihr Gerät.',
            ],
            [
                'q' => 'Welche Verschlüsselung wird verwendet?',
                'a' => 'AES-256, der moderne Standard für die PDF-Verschlüsselung, angewendet mit der Open-Source-Bibliothek QPDF, die für den Browser kompiliert wurde.',
            ],
            [
                'q' => 'Kann ich das Passwort später wieder entfernen?',
                'a' => 'Ja. Verwenden Sie das Tool „PDF entsperren" mit dem von Ihnen festgelegten Passwort, um eine Kopie ohne Passwort zu erhalten.',
            ],
            [
                'q' => 'Öffnet sich das passwortgeschützte PDF in jedem PDF-Reader?',
                'a' => 'Ja. Es verwendet das von Adobe Acrobat, Browsern und den meisten anderen PDF-Readern unterstützte Standard-Verschlüsselungsformat für PDFs, die vor dem Öffnen nach dem Passwort fragen.',
            ],
        ],
    ],

    'unlock-pdf' => [
        'name' => 'PDF entsperren',
        'title' => 'PDF entsperren - Passwort kostenlos entfernen',
        'description' => 'Entfernen Sie das Passwort eines PDFs online kostenlos, wenn Sie es kennen. Einmal eingeben und eine entsperrte Kopie herunterladen. Kein Upload.',
        'h1' => 'PDF entsperren',
        'tagline' => 'Entfernen Sie das Passwort eines PDFs, das Sie bereits kennen - direkt in Ihrem Browser.',
        'keywords' => [
            'pdf entsperren',
            'pdf passwort entfernen',
            'pdf passwort löschen',
            'pdf entschlüsseln',
            'passwort aus pdf entfernen',
        ],
        'intro' => 'Ein PDF zu entsperren entfernt dessen Öffnungspasswort, sodass es nicht mehr bei jedem Öffnen danach fragt. Dieses Tool entfernt nur ein Passwort, das Sie bereits kennen - geben Sie es einmal ein, und es wird eine neue Kopie des PDFs ohne Passwort erstellt. Es knackt, errät oder umgeht kein Passwort, das Sie nicht haben, da dies den Schutz sinnlos machen würde.',
        'steps' => [
            'Wählen Sie das passwortgeschützte PDF.',
            'Geben Sie das Passwort ein.',
            'Klicken Sie auf PDF entsperren.',
            'Laden Sie die Kopie ohne Passwort herunter.',
        ],
        'features' => [
            'Entfernt das Öffnungspasswort eines PDFs, das Sie bereits öffnen können',
            'Knackt, errät oder umgeht keine unbekannten Passwörter',
            'Funktioniert vollständig in Ihrem Browser - das PDF wird nie hochgeladen',
            'Laden Sie ein normales PDF herunter, das sich ohne Nachfrage öffnet',
            'Kein Wasserzeichen, kein Seitenlimit',
        ],
        'content' => [
            [
                'heading' => 'Warum muss ich das Passwort eingeben?',
                'body' => 'Dieses Tool entschlüsselt ein PDF mit demselben Passwort, das es bereits öffnet, statt zu versuchen, die Verschlüsselung zu knacken. Wenn Sie das Passwort nicht kennen, kann dieses Tool nicht helfen - es gibt keine zuverlässige oder verantwortungsvolle Möglichkeit, es wiederherzustellen.',
            ],
            [
                'heading' => 'Ist das etwas anderes als „PDF schützen"?',
                'body' => '„PDF schützen" fügt einem PDF ohne Passwort eines hinzu. „PDF entsperren" macht das Gegenteil: Es entfernt ein Passwort von einem PDF, das bereits eines hat, vorausgesetzt Sie geben es an.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Kann dieses Tool das Passwort eines PDFs knacken oder erraten?',
                'a' => 'Nein. Es entfernt nur ein Passwort, das Sie selbst eingeben. Wenn Sie das Passwort nicht kennen, gibt es keine legitime Möglichkeit für dieses oder irgendein anderes Tool, es für Sie wiederherzustellen.',
            ],
            [
                'q' => 'Wird mein PDF irgendwohin hochgeladen?',
                'a' => 'Nein. Das Passwort wird vollständig in Ihrem Browser geprüft und entfernt, mithilfe einer als WebAssembly kompilierten Version der Open-Source-Bibliothek QPDF, und die Datei verlässt nie Ihr Gerät.',
            ],
            [
                'q' => 'Was passiert, wenn ich das falsche Passwort eingebe?',
                'a' => 'Sie sehen eine Meldung „Falsches Passwort" und können es erneut versuchen. Die Datei selbst wird erst verändert, wenn das richtige Passwort sie erfolgreich entsperrt hat.',
            ],
            [
                'q' => 'Ändert das Entsperren noch etwas anderes am PDF?',
                'a' => 'Nein. Nur der Passwortschutz wird entfernt; Seiten, Text und Bilder bleiben genau so, wie sie waren.',
            ],
        ],
    ],

    'pdf-to-word' => [
        'name' => 'PDF zu Word',
        'title' => 'PDF-zu-Word-Konverter - Kostenlos und Privat',
        'description' => 'Konvertiere PDF online kostenlos zu Word. Text, Absätze und Überschriften werden zu einer bearbeitbaren .docx-Datei, erstellt direkt in deinem Browser.',
        'h1' => 'PDF-zu-Word-Konverter',
        'tagline' => 'Verwandle ein PDF in ein bearbeitbares Word-Dokument, direkt in deinem Browser.',
        'keywords' => [
            'pdf zu word',
            'pdf in word umwandeln',
            'pdf zu word konverter',
            'pdf zu docx',
            'pdf zu word kostenlos',
        ],
        'intro' => 'Ein PDF-zu-Word-Konverter verwandelt den Text eines PDFs in eine bearbeitbare .docx-Datei, die du in Microsoft Word, Google Docs oder LibreOffice öffnen kannst. Dieses Tool liest den Text deines PDFs und baut ihn als Absätze und Überschriften neu auf, damit du den Inhalt bearbeiten kannst, ohne alles neu zu tippen. Das PDF wird vollständig in deinem Browser gelesen und niemals an einen Server gesendet.',
        'steps' => [
            'Wähle das PDF aus oder lege es ab.',
            'Klicke auf In Word umwandeln.',
            'Lade die .docx-Datei herunter und öffne sie in Word, Google Docs oder LibreOffice.',
        ],
        'features' => [
            'Extrahiert Text in echte, bearbeitbare Absätze',
            'Erkennt Überschriften anhand der Schriftgröße, als Schätzung',
            'Behält Zeilenumbrüche und Lesereihenfolge bei',
            'Privat: das PDF wird nie hochgeladen',
            'Keine Anmeldung, kein Wasserzeichen',
        ],
        'content' => [
            [
                'heading' => 'Was umgewandelt wird, und was nicht',
                'body' => 'Ein PDF hat keine echte Struktur aus Absätzen, Tabellen oder Überschriften - nur Text, der auf einer Seite platziert ist. Dieses Tool baut Absätze und Überschriften aus diesem Text neu auf, was bei einfachen Dokumenten wie Briefen, Berichten und Artikeln gut funktioniert. Tabellen, mehrspaltige Layouts, Textfelder, Bilder sowie exakte Schriftarten oder Abstände bleiben nicht erhalten - das Ergebnis ist ein lesbares, bearbeitbares Dokument, keine pixelgenaue Kopie.',
            ],
            [
                'heading' => 'Warum kann ein gescanntes PDF nicht umgewandelt werden?',
                'body' => 'Ein gescanntes PDF ist eigentlich ein Foto einer Seite, ohne darunterliegenden auswählbaren Text, den der Browser lesen könnte. Die Umwandlung würde zuerst OCR (optische Zeichenerkennung) erfordern, um die Buchstaben zu erkennen - das macht dieses Tool nicht; wenn du den Text in deinem PDF-Reader auswählen und kopieren kannst, sollte die Umwandlung normal funktionieren.',
            ],
        ],
        'faqs' => [
            ['q' => 'Sieht die Formatierung genau wie im Original-PDF aus?', 'a' => 'Nicht genau. Text, einfache Überschriften und Zeilenumbrüche bleiben erhalten, aber Tabellen, Spalten, Bilder sowie exakte Schriftarten oder Abstände nicht. Ziel ist bearbeitbarer Text, keine pixelgenaue Kopie.'],
            ['q' => 'Kann ich ein gescanntes PDF umwandeln?', 'a' => 'Nur, wenn es bereits auswählbaren Text enthält. Eine gescannte Seite ohne Textebene hat nichts, was dieses Tool extrahieren könnte, da es keine OCR durchführt.'],
            ['q' => 'Wird mein PDF irgendwohin hochgeladen?', 'a' => 'Nein. Die gesamte Umwandlung läuft in deinem Browser mit JavaScript, und die Datei verlässt niemals dein Gerät.'],
            ['q' => 'Welche Datei bekomme ich?', 'a' => 'Eine normale .docx-Datei, die sich in Microsoft Word, Google Docs, LibreOffice Writer und den meisten anderen Textverarbeitungen öffnen lässt.'],
        ],
    ],

    'word-to-pdf' => [
        'name' => 'Word zu PDF',
        'title' => 'Word-zu-PDF-Konverter - Kostenlos und Privat',
        'description' => 'Konvertiere Word (.docx) online kostenlos zu PDF. Überschriften, Absätze, Listen, Fett-/Kursivtext und Bilder bleiben erhalten - direkt im Browser.',
        'h1' => 'Word-zu-PDF-Konverter',
        'tagline' => 'Verwandle ein Word-Dokument in ein PDF, privat in deinem Browser.',
        'keywords' => [
            'word zu pdf',
            'word in pdf umwandeln',
            'docx zu pdf',
            'word zu pdf konverter',
            'word zu pdf kostenlos',
        ],
        'intro' => 'Word zu PDF verwandelt eine bearbeitbare .docx-Datei in ein festes PDF, das auf jedem Gerät gleich aussieht und nicht leicht bearbeitet werden kann. Dieses Tool liest dein Word-Dokument und baut seine Überschriften, Absätze, Listen, Fett- oder Kursivtext und Bilder als neues PDF nach - alles in deinem Browser: Das Dokument wird nirgendwohin hochgeladen.',
        'steps' => [
            'Wähle die Word-Datei (.docx) aus oder lege sie ab.',
            'Wähle die Seitengröße A4 oder Letter.',
            'Klicke auf In PDF umwandeln und lade das Ergebnis herunter.',
        ],
        'features' => [
            'Behält Überschriften, Absätze und Zeilenumbrüche bei',
            'Behält Aufzählungen und nummerierte Listen bei',
            'Behält Fett- und Kursivtext bei',
            'Behält Bilder aus dem Dokument bei',
            'Privat: dein Dokument wird nie hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Was erhalten bleibt, und was nicht',
                'body' => 'Überschriften, Absätze, Zeilenumbrüche, Aufzählungen und nummerierte Listen, Fett- und Kursivtext sowie die meisten Bilder werden im PDF nachgebaut. Tabellen, mehrspaltige Layouts, Textfelder, Kopf- und Fußzeilen, nachverfolgte Änderungen sowie exakte Schriftarten oder die genaue Position des Original-Word-Dokuments bleiben nicht erhalten - das Ergebnis behält Inhalt und Lesereihenfolge, statt die Seite pixelgenau nachzubilden.',
            ],
            [
                'heading' => 'Nur .docx-Dateien werden unterstützt',
                'body' => 'Dieses Tool liest das moderne Word-Format (.docx). Das ältere .doc-Format von Word 2003 und früher wird nicht unterstützt; öffne die Datei in Word und nutze „Speichern als“, um zuerst eine .docx-Kopie zu erstellen.',
            ],
        ],
        'faqs' => [
            ['q' => 'Sieht mein Word-Dokument als PDF genau gleich aus?', 'a' => 'Überschriften, Absätze, Listen, Fett-/Kursivtext und Bilder bleiben erhalten, aber Tabellen, Spalten, Textfelder sowie exakte Schriftarten oder Abstände nicht. Bei den meisten Briefen, Berichten und Artikeln liest sich das Ergebnis sehr nah am Original.'],
            ['q' => 'Funktioniert das mit .doc-Dateien?', 'a' => 'Nein, nur mit dem modernen .docx-Format. Ältere .doc-Dateien müssen zuerst in Word als .docx gespeichert werden.'],
            ['q' => 'Wird mein Dokument irgendwohin hochgeladen?', 'a' => 'Nein. Die gesamte Umwandlung läuft in deinem Browser mit JavaScript, und die Datei verlässt niemals dein Gerät.'],
            ['q' => 'Welche Seitengröße verwendet das PDF?', 'a' => 'Wähle vor der Umwandlung A4 oder Letter; der Inhalt wird an die gewählte Seite angepasst.'],
        ],
    ],

    'excel-to-pdf' => [
        'name' => 'Excel zu PDF',
        'title' => 'Excel-zu-PDF-Konverter - Kostenlos und Privat',
        'description' => 'Konvertiere Excel (.xlsx, .xls) oder CSV online kostenlos zu PDF. Jedes Tabellenblatt wird eine klare, paginierte Tabelle - direkt im Browser.',
        'h1' => 'Excel-zu-PDF-Konverter',
        'tagline' => 'Verwandle eine Tabelle in eine klare, paginierte PDF-Tabelle.',
        'keywords' => [
            'excel zu pdf',
            'excel in pdf umwandeln',
            'xlsx zu pdf',
            'tabelle zu pdf',
            'csv zu pdf',
        ],
        'intro' => 'Ein Excel-zu-PDF-Konverter verwandelt eine Tabelle in ein festes Dokument, das auf jedem Gerät gleich aussieht, ohne dass Excel installiert sein muss. Dieses Tool liest deine .xlsx-, .xls- oder .csv-Datei und zeichnet jedes Tabellenblatt als Tabelle mit Rahmen, aufgeteilt auf so viele Seiten wie nötig, wobei die Kopfzeile auf jeder Seite wiederholt wird. Die Datei wird vollständig in deinem Browser gelesen und niemals hochgeladen.',
        'steps' => [
            'Wähle deine Excel-Datei (.xlsx, .xls) oder CSV-Datei aus oder lege sie ab.',
            'Wähle Seitengröße und Ausrichtung (Hoch- oder Querformat).',
            'Klicke auf In PDF umwandeln und lade das Ergebnis herunter.',
        ],
        'features' => [
            'Konvertiert .xlsx-, .xls- und .csv-Dateien',
            'Jedes Tabellenblatt wird zur eigenen Tabelle, mit auf jeder Seite wiederholter Kopfzeile',
            'Hoch- oder Querformat, A4 oder Letter',
            'Spalten passen sich automatisch an den Inhalt an',
            'Privat: deine Tabelle wird nie hochgeladen',
        ],
        'content' => [
            [
                'heading' => 'Wie eine breite Tabelle im PDF aussieht',
                'body' => 'Spalten werden an ihren Inhalt angepasst und, wo möglich, verkleinert, damit sie in die Seitenbreite passen. Hat ein Blatt immer noch zu viele Spalten, wird Text, der nicht in seine Spalte passt, mit Auslassungspunkten („…“) gekürzt, statt die nächste Spalte zu überlappen. Das Querformat gibt breiten Tabellen meist mehr Platz.',
            ],
            [
                'heading' => 'Was nicht erhalten bleibt',
                'body' => 'Dieses Tool konzentriert sich darauf, die Daten klar auf der Seite darzustellen: Zellhintergrundfarben, eigene Schriftarten, Formeln (stattdessen wird der zuletzt berechnete Wert verwendet), Diagramme und verbundene Zellen bleiben nicht erhalten.',
            ],
        ],
        'faqs' => [
            ['q' => 'Kann ich auch eine CSV-Datei konvertieren?', 'a' => 'Ja. CSV-Dateien funktionieren genauso wie .xlsx und .xls: Wähle die Datei aus, und sie wird zu einer einseitigen PDF-Tabelle.'],
            ['q' => 'Was passiert mit einem Tabellenblatt mit vielen Spalten?', 'a' => 'Die Spaltenbreite wird verkleinert, um auf die Seite zu passen, und das Querformat gibt breiten Tabellen mehr Platz. Text, der immer noch nicht in seine Spalte passt, wird mit „…“ gekürzt.'],
            ['q' => 'Bleiben Formeln oder Diagramme erhalten?', 'a' => 'Formeln zeigen ihren zuletzt berechneten Wert als Text an, nicht die Formel selbst, und Diagramme werden nicht ins PDF übernommen.'],
            ['q' => 'Wird meine Tabelle irgendwohin hochgeladen?', 'a' => 'Nein. Die gesamte Umwandlung läuft in deinem Browser mit JavaScript, und die Datei verlässt niemals dein Gerät.'],
        ],
    ],

    'pdf-to-excel' => [
        'name' => 'PDF zu Excel',
        'title' => 'PDF-zu-Excel-Konverter - Kostenlos und Privat',
        'description' => 'Konvertiere PDF online kostenlos zu Excel. Text wird bestmöglich in Zeilen und Spalten gruppiert, in einer .xlsx-Datei direkt in deinem Browser.',
        'h1' => 'PDF-zu-Excel-Konverter',
        'tagline' => 'Verwandle die Tabellen eines PDFs bestmöglich in eine Tabelle.',
        'keywords' => [
            'pdf zu excel',
            'pdf in excel umwandeln',
            'pdf zu xlsx',
            'pdf zu tabelle',
            'pdf tabelle zu excel',
        ],
        'intro' => 'Ein PDF hat keine echten Zeilen oder Spalten, nur auf einer Seite platzierten Text - die Umwandlung in eine Tabelle ist also immer eine Schätzung. Dieses Tool gruppiert Text, der dieselbe vertikale Position teilt, zu einer Zeile, ordnet dann ähnliche horizontale Startpositionen über die Seite hinweg zu Spalten und speichert das Ergebnis als .xlsx-Datei mit einem Tabellenblatt pro Seite. Das funktioniert am besten bei PDFs, die bereits wie eine Tabelle aussehen, etwa Rechnungen oder exportierte Berichte, und wird vollständig in deinem Browser gelesen.',
        'steps' => [
            'Wähle das PDF aus oder lege es ab.',
            'Klicke auf In Excel umwandeln.',
            'Lade die .xlsx-Datei herunter und öffne sie in Excel, Google Sheets oder LibreOffice Calc.',
        ],
        'features' => [
            'Gruppiert Text automatisch in Zeilen und Spalten',
            'Ein Tabellenblatt pro PDF-Seite',
            'Funktioniert gut bei Rechnungen und bereits tabellenartigen exportierten Berichten',
            'Privat: das PDF wird nie hochgeladen',
            'Keine Anmeldung, kein Wasserzeichen',
        ],
        'content' => [
            [
                'heading' => 'Wann es gut funktioniert, und wann nicht',
                'body' => 'PDFs, die bereits wie eine Tabelle aussehen (Rechnungen, Kontoauszüge, exportierte Berichte mit klaren Spalten), werden gut umgewandelt, da sich ihr Text sauber in Zeilen und Spalten einordnet. Fließtext, etwa aus Briefen oder Artikeln, hat keine echten Spalten zu erkennen und landet daher oft in einer einzigen Spalte. Verbundene Zellen, mehrzeilige Zellen und gescannte (reine Bild-)Seiten werden nicht unterstützt.',
            ],
            [
                'heading' => 'Warum ein gescanntes PDF nicht umgewandelt wird',
                'body' => 'Ein gescanntes PDF ist ein Foto einer Seite ohne darunterliegenden auswählbaren Text, also gibt es nichts, was dieses Tool lesen könnte. Die Umwandlung eines Scans erfordert zuerst OCR (optische Zeichenerkennung), das macht dieses Tool nicht; wenn du den Text in deinem PDF-Reader auswählen und kopieren kannst, sollte die Umwandlung funktionieren.',
            ],
        ],
        'faqs' => [
            ['q' => 'Werden die Spalten perfekt ausgerichtet sein?', 'a' => 'Bei PDFs, die bereits wie eine Tabelle aussehen, meist ja. Bei Fließtext gibt es keine echten Spalten zu erkennen, daher sind die Ergebnisse viel weniger zuverlässig - das ist immer eine bestmögliche Extraktion, kein exakter Tabellen-Reader.'],
            ['q' => 'Kann ich ein gescanntes PDF umwandeln?', 'a' => 'Nur, wenn es bereits auswählbaren Text enthält. Eine gescannte Seite ohne Textebene hat nichts, was dieses Tool extrahieren könnte, da es keine OCR durchführt.'],
            ['q' => 'Wie werden mehrere Seiten gehandhabt?', 'a' => 'Jede Seite des PDFs wird zu einem eigenen Tabellenblatt in der Arbeitsmappe, benannt „Page 1“, „Page 2“ und so weiter.'],
            ['q' => 'Wird mein PDF irgendwohin hochgeladen?', 'a' => 'Nein. Die gesamte Umwandlung läuft in deinem Browser mit JavaScript, und die Datei verlässt niemals dein Gerät.'],
        ],
    ],

    'html-to-pdf' => [
        'name' => 'HTML zu PDF',
        'title' => 'HTML-zu-PDF-Konverter - Kostenlos und Privat',
        'description' => 'Konvertiere HTML oder einfachen Text online kostenlos zu PDF. Code oder Text einfügen und ein PDF mit Überschriften, Listen und Formatierung herunterladen.',
        'h1' => 'HTML-zu-PDF-Konverter',
        'tagline' => 'Füge HTML oder einfachen Text ein und lade ihn als PDF herunter.',
        'keywords' => [
            'html zu pdf',
            'html in pdf umwandeln',
            'html zu pdf konverter',
            'text zu pdf',
            'html zu pdf kostenlos',
        ],
        'intro' => 'Dieser HTML-zu-PDF-Konverter verwandelt eingefügtes HTML, oder einfach nur Text, in ein herunterladbares PDF. Er versteht gängige Tags wie Überschriften, Absätze, Zeilenumbrüche, Listen, Fett- und Kursivtext sowie Bilder und ordnet sie auf A4- oder Letter-Seiten an. Er ruft nie eine andere Website ab - nur das von dir eingefügte HTML oder der Text wird verwendet, und das PDF entsteht vollständig in deinem Browser.',
        'steps' => [
            'Füge HTML oder einfachen Text in das Feld ein.',
            'Wähle die Seitengröße A4 oder Letter.',
            'Klicke auf In PDF umwandeln und lade das Ergebnis herunter.',
        ],
        'features' => [
            'Unterstützt Überschriften, Absätze und Zeilenumbrüche',
            'Unterstützt Aufzählungen und nummerierte Listen',
            'Unterstützt Fett- und Kursivtext',
            'Unterstützt Bilder als data:-URLs',
            'Ruft nie andere Websites ab - nur dein eingefügter Inhalt wird verwendet',
        ],
        'content' => [
            [
                'heading' => 'Welches HTML unterstützt wird',
                'body' => 'Überschriften (h1-h6), Absätze, Zeilenumbrüche, Aufzählungen und nummerierte Listen, Fett-/Strong- und Kursiv-/Em-Text sowie Bilder als data:-URLs werden im PDF angeordnet. Tags, die dieses Tool nicht speziell versteht, wie Tabellen, Links oder eigene Formatierungen, werden ignoriert - ihr Text bleibt aber erhalten, damit nichts stillschweigend verloren geht.',
            ],
            [
                'heading' => 'Warum kann es keine Bilder oder Seiten von einer URL abrufen?',
                'body' => 'Dieses Tool stellt nie Netzwerkanfragen in deinem Namen, daher wird ein <img src="https://...">-Tag, das auf eine andere Website zeigt, nicht angezeigt - nur bereits als data:-URL eingebettete Bilder werden gezeigt. Das hält das Tool privat und verhindert, dass ohne deine direkte Aktion eine Website kontaktiert wird.',
            ],
        ],
        'faqs' => [
            ['q' => 'Kann ich auch einfachen Text konvertieren, nicht nur HTML?', 'a' => 'Ja. Text ohne jegliche Tags wird als ein einzelner Absatz behandelt, du kannst also einfachen Text direkt einfügen.'],
            ['q' => 'Bleiben meine CSS-Stile und Farben erhalten?', 'a' => 'Nein. Dieses Tool konzentriert sich auf Struktur und lesbaren Inhalt - Überschriften, Absätze, Listen, Fett-/Kursivtext und Bilder - statt auf exakte Farben, Schriftarten oder CSS-Layout.'],
            ['q' => 'Kann es eine Webseite von einer URL umwandeln?', 'a' => 'Nein, nur HTML oder Text, den du selbst einfügst. Es ruft nie andere Websites ab, was alles privat und vorhersehbar hält.'],
            ['q' => 'Wird mein eingefügter Inhalt irgendwohin hochgeladen?', 'a' => 'Nein. Die gesamte Umwandlung läuft in deinem Browser mit JavaScript, und nichts, was du einfügst, verlässt jemals dein Gerät.'],
        ],
    ],

    'mortgage-calculator' => [
        'name' => 'Baufinanzierungsrechner',
        'title' => 'Baufinanzierungsrechner - Monatsrate & Tilgungsplan',
        'description' => 'Kostenloser Baufinanzierungsrechner: Kaufpreis, Anzahlung, Zinssatz und Laufzeit eingeben und Monatsrate, Zinsen und Tilgungsplan sehen.',
        'h1' => 'Baufinanzierungsrechner',
        'tagline' => 'Sieh deine Monatsrate, die Gesamtzinsen und den Tilgungsplan Jahr für Jahr.',
        'keywords' => [
            'baufinanzierungsrechner',
            'immobilienkredit rechner',
            'hypothekenrechner',
            'tilgungsplan rechner',
            'baufinanzierungsrechner mit sondertilgung',
        ],
        'intro' => 'Ein Baufinanzierungsrechner ermittelt die monatliche Rate aus Tilgung und Zinsen für einen Immobilienkredit anhand des Kaufpreises, der Anzahlung, des Zinssatzes und der Laufzeit. Gib unten deine Zahlen ein, um die Monatsrate, die über die gesamte Laufzeit gezahlten Gesamtzinsen und einen vollständigen Tilgungsplan Jahr für Jahr zu sehen, der zeigt, wie viel jeder Rate auf Tilgung und wie viel auf Zinsen entfällt. Eine optionale monatliche Sondertilgung zeigt, wie viel früher das Darlehen abbezahlt ist und wie viele Zinsen dadurch gespart werden.',
        'steps' => [
            'Gib den Kaufpreis ein und wähle eine Währung.',
            'Lege die Anzahlung fest, entweder als Prozentsatz oder als festen Betrag.',
            'Gib den jährlichen Zinssatz ein und wähle eine Laufzeit (10-30 Jahre, oder trage eine eigene Laufzeit ein).',
            'Trage optional eine monatliche Sondertilgung ein, um zu sehen, wie viel früher das Darlehen abbezahlt ist.',
            'Lies die Monatsrate, die Zinsen und die Gesamtkosten ab und öffne den Tilgungsplan für die Aufschlüsselung Jahr für Jahr.',
        ],
        'features' => [
            'Monatliche Rate aus Tilgung und Zinsen, Gesamtzinsen und Gesamtkosten',
            'Anzahlung in Prozent oder als fester Betrag',
            'Vollständiger Tilgungsplan Jahr für Jahr',
            'Sondertilgungen zeigen die gesparte Zeit und die gesparten Zinsen',
            'Funktioniert mit jeder Währung und jeder Laufzeit von 1 bis 50 Jahren',
            'Läuft komplett in deinem Browser - nichts von dem, was du eingibst, wird irgendwohin gesendet',
        ],
        'content' => [
            [
                'heading' => 'So wird die Monatsrate berechnet',
                'body' => 'Der Rechner nutzt die übliche Formel für die Tilgung bei festem Zinssatz: M = P x r / (1 - (1 + r)^-n), wobei P der Darlehensbetrag ist (Kaufpreis minus Anzahlung), r der monatliche Zinssatz (der Jahreszins geteilt durch 12) und n die Gesamtzahl der Monatsraten (die Laufzeit in Jahren mal 12). Das ist dieselbe Formel, die Banken bei einer Festzinsfinanzierung verwenden, und sie deckt nur Tilgung und Zinsen ab - Grundsteuer, Wohngebäudeversicherung, Kreditausfallversicherung (PMI) und Hausgeld sind nicht enthalten, da sie je nach Lage und Kreditgeber unterschiedlich sind.',
            ],
            [
                'heading' => 'Warum Sondertilgungen so viele Zinsen sparen',
                'body' => 'Jeder zusätzliche Euro, der auf die Tilgung gezahlt wird, erzeugt für den Rest des Darlehens keine Zinsen mehr. Deshalb hat eine Sondertilgung früh in der Laufzeit - wenn die Restschuld und der Zinsanteil jeder Rate am größten sind - die größte Wirkung. Der Rechner vergleicht den Tilgungsplan mit und ohne die Sondertilgung, um genau zu zeigen, um wie viele Monate das Darlehen früher abbezahlt ist und wie viele Zinsen insgesamt gespart werden.',
            ],
            [
                'heading' => 'Anzahlung: das "deposit" in Großbritannien',
                'body' => 'Der am Anfang gezahlte Betrag für eine Immobilie, der das benötigte Darlehen verringert, heißt in den USA "down payment" und in Großbritannien, Irland und mehreren anderen Ländern "deposit" - beide meinen hier dasselbe wie die Anzahlung. Eine höhere Anzahlung bedeutet ein kleineres Darlehen, eine niedrigere Monatsrate und insgesamt weniger gezahlte Zinsen, auch wenn Kreditgeber zusätzlich eigene Mindestanzahlungen und andere Zulassungsregeln haben können, die dieser Rechner nicht abdeckt.',
            ],
        ],
        'faqs' => [
            ['q' => 'Was ist in dieser Monatsrate enthalten?', 'a' => 'Nur Tilgung und Zinsen. Grundsteuer, Wohngebäudeversicherung, Kreditausfallversicherung (PMI) und Hausgeld sind nicht enthalten, da sie je nach Lage, Kreditgeber und Versicherer unterschiedlich sind.'],
            ['q' => 'Wie hilft eine monatliche Sondertilgung?', 'a' => 'Das zusätzliche Geld fließt direkt in die Tilgung des Darlehens und erzeugt dadurch für den Rest der Laufzeit keine Zinsen mehr. Der Rechner zeigt genau, um wie viele Monate das Darlehen früher abbezahlt ist und wie viele Zinsen insgesamt gespart werden.'],
            ['q' => 'Was ist eine typische Laufzeit bei einer Baufinanzierung?', 'a' => '30 Jahre sind in den USA am gängigsten; in Großbritannien und Irland sind 25 Jahre üblicher. Kürzere Laufzeiten (10-20 Jahre) bedeuten eine höhere Monatsrate, aber deutlich weniger Zinsen insgesamt.'],
            ['q' => 'Ist eine Anzahlung dasselbe wie ein "deposit"?', 'a' => 'Ja - "down payment" ist der US-Begriff und "deposit" der im Vereinigten Königreich und in Irland verwendete Begriff für denselben am Anfang gezahlten Betrag für eine Immobilie.'],
            ['q' => 'Warum weicht das Angebot meiner Bank von diesem Rechner ab?', 'a' => 'Kreditgeber rechnen Grundsteuer, Versicherung, PMI, Gebühren und ihre eigenen Rundungen hinzu, und dein tatsächlicher Zinssatz hängt von deiner Bonität, deinem Kreditgeber und der Darlehensart ab. Dieser Rechner zeigt die zugrunde liegende Tilgungs- und Zinsrechnung, damit du Szenarien schnell vergleichen kannst.'],
        ],
        'table' => [
            'caption' => 'Monatsrate und Gesamtzinsen für ein Darlehen über $300,000 bei 6,5 % nach Laufzeit (nur Tilgung und Zinsen)',
            'headers' => ['Laufzeit', 'Monatsrate', 'Gezahlte Gesamtzinsen'],
            'rows' => [
                ['15 Jahre', '$2,613.32', '$170,397.98'],
                ['20 Jahre', '$2,236.72', '$236,812.66'],
                ['25 Jahre', '$2,025.62', '$307,686.45'],
                ['30 Jahre', '$1,896.20', '$382,633.47'],
            ],
        ],
    ],
];
