# Search Console question queries: proposed tool-page FAQ changes

**APPLY AFTER 2026-11-20** (page freeze, `docs/ROUTINE.md` rule 14). Nothing in this file has been applied to tool or category pages.

Source: Search Console, 13 Aug - 13 Nov 2026, queries matching the question regex. 20 matches, all 0 clicks.

| Impr. | Pos. | Query | Page |
|---|---|---|---|
| 85 | 78.2 | when was a domain name registered | /domain-age-checker |
| 66 | 74 | when was a domain registered | /domain-age-checker |
| 64 | 77.6 | was ist meine öffentliche ipv4 adresse | /de/what-is-my-ip |
| 21 | 79.6 | when was domain registered | /domain-age-checker |
| 15 | 85 | when a domain was registered | /domain-age-checker |
| 11 | 82.3 | when was domain name registered | /domain-age-checker |
| 6 | 16 | was ist meine ip | /de/what-is-my-ip |
| 4 | 80 | how many words in a page | /guides/how-many-words-is-a-page |
| 3 | 10.7 | was ist meine ip.de | /de/what-is-my-ip |
| 2-1 | 64-123 | 7 more "how many words ... page" variants | /guides/how-many-words-is-a-page |
| 1 | 84-87 | how old is a domain / how old is the domain | /domain-age-checker |
| 1 | 68 | how to calculate percentage of growth between two numbers? | /percentage-calculator |

## Already done on 16 Nov 2026 (guides are not frozen)

- `/guides/how-many-words-is-a-page`: new question sections (double-spaced, single-spaced, A4, Microsoft Word, font size), a first-hand layout test table, 3 new FAQs (FAQPage schema is automatic for guides).
- `/guides/how-to-check-how-old-a-domain-is`: new question sections (when was a domain registered, how old is a domain, WHOIS vs RDAP, privacy, why the date can be wrong or missing), 3 new FAQs, 2 more sources. Improved instead of adding a second guide on the same question, to avoid two near-identical pages competing for the same query.
- New `/guides/how-to-calculate-percentage-growth`: formula, worked examples, negative growth, zero and negative starting values, CAGR, MoM vs YoY. It is linked automatically from /percentage-calculator's "Read the guide" list.

## Languages and guides

Guides are English only (`config/guides.php`, rule 4: never linked as /{lang}/guides), so there is no German guide to improve. `/de/what-is-my-ip` can only be helped through its tool-page fields, which are frozen: see section 3 below.

Each tool keeps 5 FAQs (SEO rule 6: 4-5), so every proposal below **replaces** an existing FAQ rather than adding a sixth. Every language in `config/locales.php` must be changed together (`config/tools.php` for en, `lang/{code}/tools.php` for the rest).

---

## 1. /domain-age-checker: two factual corrections

These two existing FAQs say things that are not true, checked on 16 Nov 2026:
- "Can I check any domain extension?" says .io and .de have RDAP records. They do not: IANA's RDAP bootstrap file (published 2026-10-28) has no entry for .de, .eu, .it, .es, .ch, .io or .co, and rdap.org returns 404 for nic.io, go.co, nic.it, rae.es, europa.eu and admin.ch. The checker shows "not supported" for them.
- "When was a domain registered?" says the Created date is "the exact day that domain name was first registered to anyone". It is the start of the *current* registration: a domain that lapsed and was registered again shows the new date. (A transfer keeps the date: wikipedia.org's RDAP record shows registration 2001-01-13 and a transfer event 2012-03-09.)

Because these are accuracy fixes rather than SEO rewording, the owner may want to approve them before 20 Nov.

### 1a. Replace the answer of "Can I check any domain extension?"

- **en** — Q: Can I check any domain extension?
  A: Most extensions can be checked, including .com, .net, .org, .co.uk, .fr, .nl and .pl. Some country-code registries do not offer RDAP yet, such as .de, .eu, .it, .es, .ch, .io and .co; for those the checker says the extension is not supported instead of guessing, and the registry's own lookup page is the place to check.
- **es** — Q: ¿Puedo comprobar cualquier extensión de dominio?
  A: Se pueden comprobar la mayoría, como .com, .net, .org, .co.uk, .fr, .nl y .pl. Algunos registros de dominios de país todavía no ofrecen RDAP, como .de, .eu, .it, .es, .ch, .io y .co; en esos casos la herramienta indica que la extensión no es compatible en lugar de adivinar, y puedes consultar la búsqueda del propio registro.
- **pt** — Q: Posso verificar qualquer extensão de domínio?
  A: A maioria pode ser verificada, como .com, .net, .org, .co.uk, .fr, .nl e .pl. Alguns registros de domínios de país ainda não oferecem RDAP, como .de, .eu, .it, .es, .ch, .io e .co; nesses casos a ferramenta informa que a extensão não é suportada em vez de adivinhar, e você pode usar a consulta do próprio registro.
- **fr** — Q : Puis-je vérifier n'importe quelle extension de domaine ?
  R : La plupart, oui, dont .com, .net, .org, .co.uk, .fr, .nl et .pl. Certains registres nationaux ne proposent pas encore RDAP, comme .de, .eu, .it, .es, .ch, .io et .co ; pour ceux-là, l'outil indique que l'extension n'est pas prise en charge au lieu de deviner, et vous pouvez utiliser la recherche du registre lui-même.
- **de** — F: Kann ich jede Domain-Endung prüfen?
  A: Die meisten, darunter .com, .net, .org, .co.uk, .fr, .nl und .pl. Einige Länder-Registrys bieten noch kein RDAP an, etwa .de, .eu, .it, .es, .ch, .io und .co. Dafür meldet das Tool, dass die Endung nicht unterstützt wird, statt zu raten. Bei .de zeigt auch die DENIC-Abfrage kein Registrierungsdatum, nur das Datum der letzten Änderung.
- **it** — D: Posso controllare qualsiasi estensione di dominio?
  R: La maggior parte sì, tra cui .com, .net, .org, .co.uk, .fr, .nl e .pl. Alcuni registri nazionali non offrono ancora RDAP, come .de, .eu, .it, .es, .ch, .io e .co; per questi lo strumento segnala che l'estensione non è supportata invece di tirare a indovinare, e puoi usare la ricerca del registro stesso.
- **pl** — P: Czy mogę sprawdzić każdą końcówkę domeny?
  O: Większość tak, w tym .com, .net, .org, .co.uk, .fr, .nl i .pl. Niektóre rejestry krajowe nie udostępniają jeszcze RDAP, np. .de, .eu, .it, .es, .ch, .io i .co; dla nich narzędzie informuje, że końcówka nie jest obsługiwana, zamiast zgadywać, a datę można sprawdzić w wyszukiwarce samego rejestru.
- **ko** — Q: 모든 도메인 확장자를 확인할 수 있나요?
  A: .com, .net, .org, .co.uk, .fr, .nl, .pl 등 대부분은 확인할 수 있습니다. 다만 .de, .eu, .it, .es, .ch, .io, .co 같은 일부 국가 도메인 등록 기관은 아직 RDAP를 제공하지 않습니다. 이런 경우 도구는 추측하지 않고 지원되지 않는 확장자라고 알려 주며, 해당 등록 기관의 조회 페이지에서 확인할 수 있습니다.
- **zh** (Traditional) — Q：可以查詢任何網域副檔名嗎？
  A：大多數都可以，包括 .com、.net、.org、.co.uk、.fr、.nl 和 .pl。部分國家網域的註冊管理機構尚未提供 RDAP，例如 .de、.eu、.it、.es、.ch、.io 和 .co；遇到這些副檔名時，工具會直接說明不支援，而不會猜測日期，您可以改用該註冊管理機構自己的查詢頁面。
- **ur** — س: کیا میں کسی بھی ڈومین ایکسٹینشن کو چیک کر سکتا ہوں؟
  ج: زیادہ تر ایکسٹینشنز چیک ہو سکتی ہیں، جیسے .com، .net، .org، .co.uk، .fr، .nl اور .pl۔ کچھ ملکی ڈومین رجسٹریاں ابھی RDAP فراہم نہیں کرتیں، جیسے .de، .eu، .it، .es، .ch، .io اور .co؛ ان کے لیے ٹول اندازہ لگانے کے بجائے بتا دیتا ہے کہ ایکسٹینشن سپورٹ نہیں ہے، اور آپ متعلقہ رجسٹری کا اپنا تلاش صفحہ استعمال کر سکتے ہیں۔

### 1b. Replace the answer of "When was a domain registered?"

- **en** — Q: When was a domain registered?
  A: The domain's RDAP record stores a Created (registration) date: the day the current registration began. A sale or a move to another registrar keeps that date, but a domain that expired and was registered again shows the new date. Enter the domain above and the checker reads the date straight from the registry, with the age in years, months and days.
- **es** — Q: ¿Cuándo se registró un dominio?
  A: El registro RDAP del dominio guarda una fecha de creación (registro): el día en que empezó el registro actual. Una venta o un cambio de registrador mantienen esa fecha, pero un dominio que caducó y se volvió a registrar muestra la nueva. Escribe el dominio arriba y la herramienta lee la fecha directamente del registro, con la antigüedad en años, meses y días.
- **pt** — Q: Quando um domínio foi registrado?
  A: O registro RDAP do domínio guarda uma data de criação (registro): o dia em que o registro atual começou. Uma venda ou a troca de registrador mantêm essa data, mas um domínio que expirou e foi registrado de novo mostra a data nova. Digite o domínio acima e a ferramenta lê a data direto do registro, com a idade em anos, meses e dias.
- **fr** — Q : Quand un domaine a-t-il été enregistré ?
  R : L'enregistrement RDAP du domaine contient une date de création (enregistrement) : le jour où l'enregistrement actuel a commencé. Une vente ou un changement de bureau d'enregistrement conserve cette date, mais un domaine expiré puis réenregistré affiche la nouvelle. Saisissez le domaine ci-dessus : l'outil lit la date directement auprès du registre, avec l'âge en années, mois et jours.
- **de** — F: Wann wurde eine Domain registriert?
  A: Der RDAP-Eintrag einer Domain enthält ein Erstellungsdatum (Registrierung): den Tag, an dem die aktuelle Registrierung begann. Ein Verkauf oder ein Wechsel des Registrars ändert dieses Datum nicht, eine abgelaufene und neu registrierte Domain zeigt aber das neue Datum. Gib die Domain oben ein, und das Tool liest das Datum direkt bei der Registry aus, mit dem Alter in Jahren, Monaten und Tagen.
- **it** — D: Quando è stato registrato un dominio?
  R: Il record RDAP del dominio contiene una data di creazione (registrazione): il giorno in cui è iniziata la registrazione attuale. Una vendita o un cambio di registrar mantengono quella data, ma un dominio scaduto e registrato di nuovo mostra quella nuova. Inserisci il dominio qui sopra e lo strumento legge la data direttamente dal registro, con l'età in anni, mesi e giorni.
- **pl** — P: Kiedy domena została zarejestrowana?
  O: Rekord RDAP domeny zawiera datę utworzenia (rejestracji): dzień, w którym zaczęła się obecna rejestracja. Sprzedaż lub zmiana rejestratora nie zmienia tej daty, ale domena, która wygasła i została zarejestrowana ponownie, pokazuje nową datę. Wpisz domenę powyżej, a narzędzie odczyta datę prosto z rejestru, razem z wiekiem w latach, miesiącach i dniach.
- **ko** — Q: 도메인은 언제 등록되었나요?
  A: 도메인의 RDAP 기록에는 생성(등록) 날짜가 저장되어 있으며, 이는 현재 등록이 시작된 날입니다. 판매되거나 다른 등록 대행자로 이전되어도 이 날짜는 유지되지만, 만료된 뒤 다시 등록된 도메인은 새 날짜가 표시됩니다. 위에 도메인을 입력하면 등록 기관에서 날짜를 직접 읽어 연, 월, 일 단위의 나이와 함께 보여 줍니다.
- **zh** (Traditional) — Q：網域是什麼時候註冊的？
  A：網域的 RDAP 記錄存有建立（註冊）日期，也就是目前這次註冊開始的日子。網域被出售或轉移到其他註冊商時，這個日期不會改變；但網域過期後被重新註冊，就會顯示新的日期。在上方輸入網域，工具會直接向註冊管理機構讀取日期，並以年、月、日顯示網域年齡。
- **ur** — س: ڈومین کب رجسٹر ہوا تھا؟
  ج: ڈومین کے RDAP ریکارڈ میں تخلیق (رجسٹریشن) کی تاریخ محفوظ ہوتی ہے، یعنی وہ دن جب موجودہ رجسٹریشن شروع ہوئی۔ ڈومین بیچنے یا دوسرے رجسٹرار کے پاس منتقل کرنے سے یہ تاریخ نہیں بدلتی، لیکن جو ڈومین ایکسپائر ہو کر دوبارہ رجسٹر ہو، اس کی نئی تاریخ دکھائی دیتی ہے۔ اوپر ڈومین درج کریں، ٹول یہ تاریخ براہِ راست رجسٹری سے پڑھ کر سال، مہینے اور دن میں عمر کے ساتھ دکھاتا ہے۔

---

## 2. /percentage-calculator: answer "percentage growth between two numbers"

Replace FAQ 2 ("How do I calculate percentage increase?") with a growth question that also covers decreases, and replace FAQ 4 ("Is a 'percentage calculator' the same as a 'percent calculator'?", thin) with the multi-year growth question. Answers match `/guides/how-to-calculate-percentage-growth`.

### 2a. Replaces FAQ 2

- **en** — Q: How do I calculate percentage growth between two numbers?
  A: Subtract the old value from the new value, divide by the old value and multiply by 100. From 80 to 100: (100 - 80) / 80 x 100 = 25% growth. A negative result is a decrease: from 100 to 80 is -20%.
- **es** — Q: ¿Cómo calculo el crecimiento porcentual entre dos números?
  A: Resta el valor antiguo al nuevo, divide entre el valor antiguo y multiplica por 100. De 80 a 100: (100 - 80) / 80 x 100 = 25 % de crecimiento. Un resultado negativo es una disminución: de 100 a 80 es -20 %.
- **pt** — Q: Como calculo o crescimento percentual entre dois números?
  A: Subtraia o valor antigo do novo, divida pelo valor antigo e multiplique por 100. De 80 para 100: (100 - 80) / 80 x 100 = 25% de crescimento. Um resultado negativo é uma queda: de 100 para 80 é -20%.
- **fr** — Q : Comment calculer la croissance en pourcentage entre deux nombres ?
  R : Soustrayez l'ancienne valeur de la nouvelle, divisez par l'ancienne valeur et multipliez par 100. De 80 à 100 : (100 - 80) / 80 x 100 = 25 % de croissance. Un résultat négatif est une baisse : de 100 à 80, c'est -20 %.
- **de** — F: Wie berechne ich das prozentuale Wachstum zwischen zwei Zahlen?
  A: Ziehe den alten Wert vom neuen ab, teile durch den alten Wert und multipliziere mit 100. Von 80 auf 100: (100 - 80) / 80 x 100 = 25 % Wachstum. Ein negatives Ergebnis ist ein Rückgang: von 100 auf 80 sind es -20 %.
- **it** — D: Come calcolo la crescita percentuale tra due numeri?
  R: Sottrai il valore vecchio da quello nuovo, dividi per il valore vecchio e moltiplica per 100. Da 80 a 100: (100 - 80) / 80 x 100 = 25% di crescita. Un risultato negativo è una diminuzione: da 100 a 80 è -20%.
- **pl** — P: Jak obliczyć procentowy wzrost między dwiema liczbami?
  O: Odejmij starą wartość od nowej, podziel przez starą wartość i pomnóż przez 100. Z 80 do 100: (100 - 80) / 80 x 100 = 25% wzrostu. Wynik ujemny oznacza spadek: ze 100 do 80 to -20%.
- **ko** — Q: 두 숫자 사이의 증가율(%)은 어떻게 계산하나요?
  A: 새 값에서 이전 값을 빼고, 이전 값으로 나눈 뒤 100을 곱합니다. 80에서 100이 되면 (100 - 80) / 80 x 100 = 25% 증가입니다. 결과가 음수이면 감소를 뜻합니다. 100에서 80이 되면 -20%입니다.
- **zh** (Traditional) — Q：如何計算兩個數字之間的成長百分比？
  A：用新數值減去舊數值，再除以舊數值，然後乘以 100。從 80 到 100：(100 - 80) / 80 x 100 = 成長 25%。結果為負數代表減少：從 100 到 80 是 -20%。
- **ur** — س: دو اعداد کے درمیان فیصد اضافہ (گروتھ) کیسے نکالوں؟
  ج: نئی قدر میں سے پرانی قدر نفی کریں، پرانی قدر سے تقسیم کریں اور 100 سے ضرب دیں۔ 80 سے 100: ‎(100 - 80) / 80 x 100 = 25%‎ اضافہ۔ منفی نتیجہ کمی ظاہر کرتا ہے: 100 سے 80 ‎-20%‎ ہے۔

### 2b. Replaces FAQ 4

- **en** — Q: How do I calculate average yearly growth over several years?
  A: Use the compound annual growth rate: (final value / starting value) to the power of 1 / years, minus 1, times 100. From 50,000 to 80,000 in 4 years is about 12.47% a year, not 15%, because each year's growth builds on the last.
- **es** — Q: ¿Cómo calculo el crecimiento medio anual de varios años?
  A: Usa la tasa de crecimiento anual compuesta: (valor final / valor inicial) elevado a 1 / años, menos 1, por 100. De 50.000 a 80.000 en 4 años es aproximadamente un 12,47 % al año, no un 15 %, porque el crecimiento de cada año se suma al anterior.
- **pt** — Q: Como calculo o crescimento médio anual ao longo de vários anos?
  A: Use a taxa de crescimento anual composta: (valor final / valor inicial) elevado a 1 / anos, menos 1, vezes 100. De 50.000 para 80.000 em 4 anos dá cerca de 12,47% ao ano, não 15%, porque o crescimento de cada ano se soma ao do anterior.
- **fr** — Q : Comment calculer la croissance annuelle moyenne sur plusieurs années ?
  R : Utilisez le taux de croissance annuel composé : (valeur finale / valeur de départ) puissance 1 / nombre d'années, moins 1, fois 100. De 50 000 à 80 000 en 4 ans, cela fait environ 12,47 % par an, et non 15 %, car la croissance de chaque année s'ajoute à celle de la précédente.
- **de** — F: Wie berechne ich das durchschnittliche jährliche Wachstum über mehrere Jahre?
  A: Mit der durchschnittlichen jährlichen Wachstumsrate (CAGR): (Endwert / Anfangswert) hoch 1 / Anzahl der Jahre, minus 1, mal 100. Von 50.000 auf 80.000 in 4 Jahren sind das etwa 12,47 % pro Jahr, nicht 15 %, weil jedes Jahr auf dem Wachstum des Vorjahres aufbaut.
- **it** — D: Come calcolo la crescita media annua su più anni?
  R: Usa il tasso di crescita annuo composto (CAGR): (valore finale / valore iniziale) elevato a 1 / anni, meno 1, per 100. Da 50.000 a 80.000 in 4 anni è circa il 12,47% all'anno, non il 15%, perché la crescita di ogni anno si somma a quella del precedente.
- **pl** — P: Jak obliczyć średni roczny wzrost z kilku lat?
  O: Użyj składanej rocznej stopy wzrostu (CAGR): (wartość końcowa / wartość początkowa) do potęgi 1 / liczba lat, minus 1, razy 100. Z 50 000 do 80 000 w 4 lata to około 12,47% rocznie, a nie 15%, bo wzrost każdego roku nakłada się na poprzedni.
- **ko** — Q: 여러 해에 걸친 연평균 성장률은 어떻게 계산하나요?
  A: 연평균 복합 성장률(CAGR)을 사용합니다. (최종 값 / 시작 값)을 1 / 연수 제곱한 뒤 1을 빼고 100을 곱합니다. 4년 동안 50,000에서 80,000이 되었다면 연 15%가 아니라 약 12.47%입니다. 매년의 성장이 전년도 성장 위에 쌓이기 때문입니다.
- **zh** (Traditional) — Q：如何計算多年的平均年成長率？
  A：使用年複合成長率（CAGR）：(最終值 / 起始值) 的 1 / 年數 次方，減 1 後乘以 100。4 年內從 50,000 成長到 80,000，約為每年 12.47%，而不是 15%，因為每年的成長都建立在前一年的基礎上。
- **ur** — س: کئی سالوں میں اوسط سالانہ اضافہ کیسے نکالوں؟
  ج: کمپاؤنڈ سالانہ شرحِ نمو (CAGR) استعمال کریں: (آخری قدر / ابتدائی قدر) کی طاقت 1 / سال، اس میں سے 1 نفی کریں اور 100 سے ضرب دیں۔ 4 سال میں 50,000 سے 80,000 تقریباً 12.47% سالانہ ہے، 15% نہیں، کیونکہ ہر سال کا اضافہ پچھلے سال کے اضافے پر بنتا ہے۔

---

## 3. /de/what-is-my-ip (and the same tool in every language): "Was ist meine öffentliche IPv4-Adresse?"

Facts checked on 16 Nov 2026: ilovemytools.store has an A record (192.124.249.6) and **no AAAA record**, so visitors reach the site over IPv4 and the page always shows the visitor's public IPv4 address (on IPv6-only mobile networks, the carrier's IPv4 gateway address). The tool (`resources/js/tools/WhatIsMyIp.jsx`) shows one address, the one used to reach the server. If the hosting ever adds IPv6, this FAQ must be reworded.

Replace FAQ 5 ("How do I find my public IP address?" / "Wie finde ich meine öffentliche IP-Adresse heraus?"), whose answer is close to the intro, with:

- **en** — Q: What is my public IPv4 address?
  A: It is the address shown at the top of this page. Our site is currently reached over IPv4 only, so the address you see, such as 203.0.113.42, is the public IPv4 address your connection uses. Your device may also have an IPv6 address, which this page does not show.
- **es** — Q: ¿Cuál es mi dirección IPv4 pública?
  A: Es la dirección que aparece arriba en esta página. Ahora mismo nuestro sitio solo es accesible por IPv4, así que la dirección que ves, por ejemplo 203.0.113.42, es la IPv4 pública que usa tu conexión. Tu dispositivo también puede tener una dirección IPv6, que esta página no muestra.
- **pt** — Q: Qual é o meu endereço IPv4 público?
  A: É o endereço mostrado no topo desta página. No momento nosso site só é acessado por IPv4, então o endereço que você vê, como 203.0.113.42, é o IPv4 público que a sua conexão usa. Seu dispositivo também pode ter um endereço IPv6, que esta página não mostra.
- **fr** — Q : Quelle est mon adresse IPv4 publique ?
  R : C'est l'adresse affichée en haut de cette page. Notre site n'est actuellement accessible qu'en IPv4 : l'adresse que vous voyez, par exemple 203.0.113.42, est donc l'adresse IPv4 publique de votre connexion. Votre appareil peut aussi avoir une adresse IPv6, que cette page n'affiche pas.
- **de** — F: Was ist meine öffentliche IPv4-Adresse?
  A: Die Adresse oben auf dieser Seite. Unsere Website ist derzeit nur über IPv4 erreichbar, daher ist die angezeigte Adresse, etwa 203.0.113.42, die öffentliche IPv4-Adresse deiner Verbindung. Dein Gerät kann zusätzlich eine IPv6-Adresse haben, die diese Seite nicht anzeigt.
- **it** — D: Qual è il mio indirizzo IPv4 pubblico?
  R: È l'indirizzo mostrato in cima a questa pagina. Al momento il nostro sito è raggiungibile solo via IPv4, quindi l'indirizzo che vedi, ad esempio 203.0.113.42, è l'IPv4 pubblico della tua connessione. Il tuo dispositivo può avere anche un indirizzo IPv6, che questa pagina non mostra.
- **pl** — P: Jaki jest mój publiczny adres IPv4?
  O: To adres widoczny na górze tej strony. Nasza witryna jest obecnie dostępna tylko przez IPv4, więc pokazany adres, np. 203.0.113.42, to publiczny adres IPv4 Twojego połączenia. Twoje urządzenie może mieć też adres IPv6, którego ta strona nie pokazuje.
- **ko** — Q: 내 공인 IPv4 주소는 무엇인가요?
  A: 이 페이지 맨 위에 표시된 주소입니다. 현재 저희 사이트는 IPv4로만 접속되므로, 보이는 주소(예: 203.0.113.42)가 사용 중인 연결의 공인 IPv4 주소입니다. 기기에 IPv6 주소가 따로 있을 수 있지만 이 페이지에는 표시되지 않습니다.
- **zh** (Traditional) — Q：我的公用 IPv4 位址是什麼？
  A：就是本頁頂端顯示的位址。本網站目前只能透過 IPv4 連線，因此您看到的位址（例如 203.0.113.42）就是您連線所使用的公用 IPv4 位址。您的裝置也可能有 IPv6 位址，但本頁不會顯示。
- **ur** — س: میرا پبلک IPv4 ایڈریس کیا ہے؟
  ج: یہ وہی ایڈریس ہے جو اس صفحے کے اوپر دکھایا گیا ہے۔ ہماری سائٹ فی الحال صرف IPv4 کے ذریعے کھلتی ہے، اس لیے جو ایڈریس آپ دیکھ رہے ہیں، جیسے 203.0.113.42، وہی آپ کے کنکشن کا پبلک IPv4 ایڈریس ہے۔ آپ کے ڈیوائس کا IPv6 ایڈریس بھی ہو سکتا ہے، جو یہ صفحہ نہیں دکھاتا۔

### Optional, owner decision (title/H1 change, higher risk)

The German H1 and title start with "Wie ist meine IP-Adresse?", while the Search Console queries use "was ist meine ip" (positions 10.7-16, the page's best German rankings). The German content already has an H2 "Was ist meine öffentliche IP-Adresse?". Changing the German title/H1 to "Was ist meine IP-Adresse?" could match the query better but touches a page that is ranking on page 1-2; per rule 14, revert it if impressions drop within days. Not recommended in the same week as the FAQ change, so any effect can be told apart.
