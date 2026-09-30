<?php

return [
    'text-tools' => [
        'name' => 'Ferramentas de texto',
        'short' => 'Texto',
        'subtitle' => 'Conte e converta seu texto',
        'title' => 'Ferramentas de texto grátis: contar palavras e maiúsculas',
        'description' => 'Ferramentas de texto online grátis para contar palavras e caracteres, trocar maiúsculas e minúsculas e revisar seus textos. Resultados na hora, sem cadastro.',
        'intro' => 'Conte palavras, veja o tempo de leitura e converta maiúsculas e minúsculas na hora. Tudo funciona no seu navegador, então seu texto continua privado.',
        'content' => [
            ['heading' => 'Qual ferramenta de texto devo usar?', 'body' => 'Use o Contador de palavras quando tiver um limite para cumprir: redações, cartas de apresentação, descrições de produtos, posts em redes sociais ou meta tags de SEO. Ele conta palavras, caracteres com e sem espaços, frases e parágrafos, e estima o tempo de leitura e de fala. Use o Conversor de maiúsculas e minúsculas quando as palavras estiverem certas mas as maiúsculas não: texto digitado com o Caps Lock ligado, títulos ou nomes de variáveis em camelCase ou snake_case.'],
            ['heading' => 'Essas ferramentas de texto são privadas?', 'body' => 'As duas funcionam inteiramente no seu navegador. O texto que você cola é processado no seu próprio dispositivo e nunca é enviado ao nosso servidor nem armazenado, então você pode usá-las com rascunhos, e-mails e documentos confidenciais. Depois que a página carrega, elas continuam funcionando mesmo se a conexão cair.'],
        ],
        'faqs' => [
            ['q' => 'Como conto as palavras de um documento?', 'a' => 'Copie o texto do Word, do Google Docs ou de um PDF e cole no Contador de palavras. Os totais são atualizados na hora, com caracteres, frases, parágrafos e tempo de leitura.'],
            ['q' => 'Como passo um texto de maiúsculas para minúsculas?', 'a' => 'Cole o texto no Conversor e escolha minúsculas. Você também pode passar para Tipo Título, Tipo frase, camelCase, snake_case e mais, e copiar o resultado.'],
            ['q' => 'Essas ferramentas custam alguma coisa?', 'a' => 'Não. As duas são grátis, sem cadastro, sem limite diário e sem limite de tamanho de texto.'],
        ],
    ],
    'image-tools' => [
        'name' => 'Ferramentas de imagem',
        'short' => 'Imagem',
        'subtitle' => 'Comprima, redimensione e converta',
        'title' => 'Ferramentas de imagem grátis: comprimir e redimensionar',
        'description' => 'Comprima, redimensione e converta imagens JPG, PNG e WebP de graça. As imagens são processadas no seu navegador e nunca são enviadas a um servidor.',
        'intro' => 'Deixe suas imagens mais leves, redimensione fotos para medidas exatas e converta entre JPG, PNG e WebP. Suas imagens nunca saem do seu dispositivo.',
        'content' => [
            ['heading' => 'Devo comprimir ou redimensionar a imagem?', 'body' => 'Comprima quando a imagem está boa mas o arquivo é grande demais, por exemplo para ficar abaixo de um limite de envio como 100 KB ou para um site carregar mais rápido: o Compressor de imagens mantém as dimensões e reduz o tamanho do arquivo. Redimensione quando a imagem tem o tamanho errado, como uma foto de 4000 pixels que precisa ter 1080 de largura para redes sociais. Diminuir uma foto grande também deixa o arquivo bem menor.'],
            ['heading' => 'JPG, PNG ou WebP: qual formato é melhor?', 'body' => 'JPG é o melhor para fotos; PNG, para logos, capturas de tela e tudo que precisa de transparência; e WebP, para a web, porque gera os menores arquivos nos dois casos. Segundo o Google, imagens WebP sem perdas são cerca de 26% menores que PNG, e WebP com perdas 25% a 34% menores que JPEG equivalentes.'],
        ],
        'faqs' => [
            ['q' => 'Como reduzo uma imagem para 100 KB?', 'a' => 'Abra o Compressor de imagens, escolha Tamanho desejado e digite 100. A ferramenta encontra a melhor qualidade que cabe e só reduz as dimensões se for necessário.'],
            ['q' => 'Posso converter PNG para JPG ou WebP para PNG aqui?', 'a' => 'Sim. O redimensionador e conversor alterna entre JPG, PNG e WebP, com ou sem mudança de tamanho. As áreas transparentes ficam brancas ao salvar em JPG.'],
            ['q' => 'Minhas fotos são enviadas a um servidor?', 'a' => 'Não. As imagens são processadas no seu navegador com a Canvas API e nunca saem do seu dispositivo.'],
        ],
    ],
    'pdf-tools' => [
        'name' => 'Ferramentas de PDF',
        'short' => 'PDF',
        'subtitle' => 'Junte, divida e converta PDFs',
        'title' => 'Ferramentas de PDF grátis: juntar e dividir arquivos PDF',
        'description' => 'Junte e divida arquivos PDF online de graça. Sem uploads, sem marca d\'água e sem cadastro. Os PDFs são processados de forma privada no seu navegador.',
        'intro' => 'Junte vários PDFs em um só ou extraia apenas as páginas de que precisa. Os arquivos são processados no seu dispositivo, sem marca d\'água nem limites escondidos.',
        'content' => [
            ['heading' => 'Juntar ou dividir: de qual ferramenta de PDF eu preciso?', 'body' => 'Use Juntar PDF para unir vários arquivos em um só documento, na ordem que você escolher, por exemplo currículo, carta de apresentação e certificados de uma candidatura. Use Dividir PDF para o contrário: separar páginas escolhidas em um novo arquivo, cortar um documento em intervalos ou salvar cada página como um PDF próprio.'],
            ['heading' => 'É seguro editar PDF online?', 'body' => 'Na maioria dos sites de PDF, seu documento é enviado a um servidor. Aqui as duas ferramentas funcionam dentro do seu navegador, então contratos, extratos bancários e outros arquivos privados nunca saem do seu dispositivo, e o resultado não tem marca d\'água nem limite de páginas.'],
        ],
        'faqs' => [
            ['q' => 'Como junto vários PDFs em um só?', 'a' => 'Abra Juntar PDF, adicione dois ou mais arquivos, coloque-os na ordem com as setas e clique em Juntar PDF. O arquivo combinado é baixado na hora.'],
            ['q' => 'Como extraio páginas de um PDF?', 'a' => 'Abra Dividir PDF, escolha Extrair páginas, digite as páginas de que precisa, como 1-3, 5, e clique em Dividir PDF.'],
            ['q' => 'Posso juntar PDFs protegidos por senha?', 'a' => 'Não diretamente. Abra o arquivo com a senha, salve ou imprima uma cópia sem proteção e junte essa cópia.'],
        ],
    ],
    'calculators' => [
        'name' => 'Calculadoras',
        'short' => 'Calculadoras',
        'subtitle' => 'Resolva as contas do dia a dia',
        'title' => 'Calculadoras online grátis: idade e porcentagem',
        'description' => 'Calculadoras online grátis de idade, porcentagem, variação percentual e mais. Respostas exatas na hora, com a fórmula e o cálculo explicados.',
        'intro' => 'Calculadoras rápidas e precisas para as contas do dia a dia: idade exata, porcentagens, aumentos e descontos.',
        'content' => [
            ['heading' => 'O que essas calculadoras calculam?', 'body' => 'A Calculadora de idade mostra a idade exata em anos, meses e dias a partir de uma data de nascimento, o dia da semana em que você nasceu e a contagem para o próximo aniversário, e considera os anos bissextos. A Calculadora de porcentagem reúne as perguntas mais comuns: X% de Y, quantos por cento X é de Y, o aumento ou a redução percentual entre dois números e somar ou subtrair uma porcentagem, como um desconto ou um imposto.'],
            ['heading' => 'Como confiro o resultado?', 'body' => 'Cada resultado mostra a fórmula usada, para você acompanhar a conta em lições de casa, descontos, aumentos de salário ou relatórios. Por exemplo, a variação percentual de 80 para 100 é (100 - 80) / 80 x 100 = 25%.'],
        ],
        'faqs' => [
            ['q' => 'Como a idade é calculada exatamente?', 'a' => 'Primeiro contam-se os anos completos, depois os meses completos e por fim os dias restantes. É o mesmo método dos documentos oficiais.'],
            ['q' => 'Como calculo um aumento percentual?', 'a' => 'Subtraia o valor antigo do novo, divida pelo valor antigo e multiplique por 100. A Calculadora de porcentagem faz isso por você e mostra a fórmula.'],
            ['q' => 'As calculadoras são grátis?', 'a' => 'Sim. São grátis, não pedem cadastro e funcionam no seu navegador, então nada do que você digita é guardado.'],
        ],
    ],
    'generators' => [
        'name' => 'Geradores',
        'short' => 'Geradores',
        'subtitle' => 'QR codes e senhas',
        'title' => 'Geradores grátis: QR codes e senhas fortes',
        'description' => 'Gere grátis QR codes para links e Wi-Fi e senhas aleatórias fortes. Sem cadastro, sem rastreamento e sem guardar nada do que você cria.',
        'intro' => 'Crie QR codes para links, Wi-Fi e contatos e gere senhas aleatórias fortes direto no seu dispositivo.',
        'content' => [
            ['heading' => 'QR codes e senhas criados no seu dispositivo', 'body' => 'O Gerador de QR code cria códigos para links, texto, redes Wi-Fi, e-mail, telefone e SMS, com as cores e tamanhos que você quiser, em PNG para telas ou SVG para impressão. O Gerador de senhas cria senhas aleatórias de 4 a 128 caracteres com o gerador de números aleatórios criptograficamente seguro do seu navegador.'],
            ['heading' => 'Por que esses códigos e senhas não expiram?', 'body' => 'Os QR codes são estáticos: seus dados ficam dentro do próprio código, e não atrás de um link de redirecionamento, então funcionam para sempre e não dependem deste site. As senhas são geradas no seu dispositivo e nunca enviadas, então não existe cópia em nenhum servidor.'],
        ],
        'faqs' => [
            ['q' => 'Como crio um QR code de Wi-Fi?', 'a' => 'Escolha Wi-Fi no Gerador de QR code, informe o nome da rede, a senha e o tipo de segurança e baixe o código. Os visitantes escaneiam e entram na rede sem digitar a senha.'],
            ['q' => 'Qual deve ser o tamanho de uma senha?', 'a' => 'Pelo menos 15 caracteres, o mínimo das diretrizes atuais do NIST, e 16 ou mais para contas importantes.'],
            ['q' => 'Posso usar os QR codes comercialmente?', 'a' => 'Sim. Os códigos que você cria podem ser usados de graça em embalagens, cardápios, panfletos e cartões de visita.'],
        ],
    ],
    'games' => [
        'name' => 'Sorte e jogos',
        'short' => 'Jogos',
        'subtitle' => 'Dados, moedas e roletas',
        'title' => 'Jogar dados, cara ou coroa e roleta aleatória grátis',
        'description' => 'Dados virtuais, cara ou coroa, roleta para sortear e gerador de números aleatórios grátis. Resultados justos e aleatórios com animações. Sem cadastro.',
        'intro' => 'Jogue dados, lance uma moeda, gire uma roleta ou sorteie números. Cada resultado é gerado de forma justa no seu dispositivo, com aleatoriedade segura.',
        'content' => [
            ['heading' => 'Qual ferramenta de sorteio devo usar?', 'body' => 'Use os Dados virtuais em jogos de tabuleiro e RPG (do D4 ao D100, até 10 dados de uma vez). Tire cara ou coroa para decidir rápido entre sim e não ou quem começa. Gire a roleta para sortear um nome ou opção de uma lista de até 100 itens, e use o Gerador de números aleatórios para rifas, loterias e amostragens, com ou sem repetição.'],
            ['heading' => 'Os resultados são mesmo aleatórios?', 'body' => 'Todas as ferramentas usam a Web Crypto API do seu navegador, uma fonte de aleatoriedade criptograficamente segura, então cada resultado tem a mesma chance e não pode ser previsto. O resultado é definido antes de a animação começar, por isso a animação não o influencia.'],
        ],
        'faqs' => [
            ['q' => 'Como sorteio um nome de uma lista?', 'a' => 'Cole os nomes na roleta, um por linha, e toque em Girar. Marque "Remover o vencedor após cada giro" para sortear vários nomes sem repetir.'],
            ['q' => 'Como gero números da loteria?', 'a' => 'Use o Gerador de números aleatórios com o atalho "Loteria 6 de 49", ou escolha seu próprio intervalo e quantidade com "Sem repetidos" marcado.'],
            ['q' => 'Cara ou coroa online é justo?', 'a' => 'Sim. Cada lançamento tem exatamente 50% de chance de cara e 50% de coroa, com aleatoriedade segura.'],
        ],
    ],
    'time-tools' => [
        'name' => 'Ferramentas de tempo',
        'short' => 'Tempo',
        'subtitle' => 'Timer, cronômetro e sono',
        'title' => 'Ferramentas de tempo grátis: cronômetro e timer',
        'description' => 'Um cronômetro preciso com voltas e um timer com alarme e atalhos rápidos. Grátis, sem cadastro e com o tempo exato mesmo com a aba em segundo plano.',
        'intro' => 'Um cronômetro preciso com voltas e um timer com alarme. Os dois mantêm o tempo exato mesmo com a aba em segundo plano.',
        'content' => [
            ['heading' => 'Cronômetro, timer ou calculadora do sono?', 'body' => 'Use o Cronômetro para medir quanto tempo algo leva, com voltas e tempos parciais em centésimos de segundo. Use o Timer quando você sabe quanto tempo tem, para cozinhar, estudar ou fazer um Pomodoro de 25 minutos, e quer um alarme no fim. Use a Calculadora do sono para planejar a hora de dormir ou acordar com base em ciclos de 90 minutos, ou para contar quantas horas você dormiu.'],
            ['heading' => 'Eles continuam precisos numa aba em segundo plano?', 'body' => 'Sim. Os navegadores deixam lentas as abas em segundo plano, por isso essas ferramentas calculam o tempo a partir de um momento fixo de início ou de fim com o relógio de alta resolução do dispositivo, em vez de contar tiques. A leitura está certa quando você volta, e o Timer também mostra o tempo restante no título da aba.'],
        ],
        'faqs' => [
            ['q' => 'Posso deixar o timer rodando enquanto uso outras abas?', 'a' => 'Sim. Mantenha a aba aberta: o tempo continua exato e o alarme toca normalmente quando a contagem termina.'],
            ['q' => 'Posso registrar tempos de volta?', 'a' => 'Sim. Toque em Volta (ou L) no Cronômetro. Cada volta mostra seu próprio tempo e o total, e você pode copiar todas de uma vez.'],
            ['q' => 'Quantas horas de sono um adulto precisa?', 'a' => 'A National Sleep Foundation recomenda de 7 a 9 horas por noite para adultos de 18 a 64 anos.'],
        ],
    ],
    'developer-tools' => [
        'name' => 'Ferramentas para desenvolvedores',
        'short' => 'Dev',
        'subtitle' => 'Formate, codifique e inspecione',
        'title' => 'Ferramentas para desenvolvedores: JSON, Base64 e IP',
        'description' => 'Utilitários online grátis para desenvolvedores: formate e valide JSON, codifique e decodifique Base64 e veja seu IP público na hora.',
        'intro' => 'Utilitários do dia a dia para desenvolvedores e profissionais de TI: formatar JSON, codificar Base64 e consultar seu endereço IP.',
        'content' => [
            ['heading' => 'Utilitários do dia a dia para desenvolvedores', 'body' => 'O Formatador de JSON embeleza, valida e minifica JSON e aponta a linha e a coluna exatas de qualquer erro. O codificador e decodificador Base64 converte texto ou arquivos para Base64 e de volta, incluindo a variante segura para URL e data URLs para HTML e CSS. Qual é o meu IP mostra seu endereço IP público, se é IPv4 ou IPv6, e detalhes do navegador e do dispositivo.'],
            ['heading' => 'É seguro colar dados de uma API aqui?', 'body' => 'Sim. As ferramentas de JSON e Base64 funcionam inteiramente no seu navegador, então respostas de API, tokens e arquivos de configuração nunca são enviados a um servidor. A única requisição que o site faz é a que o Qual é o meu IP precisa para ler seu endereço público, que é mostrado a você e não é guardado.'],
        ],
        'faqs' => [
            ['q' => 'Por que meu JSON é inválido?', 'a' => 'As causas mais comuns são vírgulas sobrando, aspas simples em vez de duplas, chaves sem aspas e comentários. O JSON padrão não permite nenhum deles.'],
            ['q' => 'Base64 é criptografia?', 'a' => 'Não. Base64 é uma codificação que qualquer pessoa pode reverter, então nunca a use para proteger senhas ou segredos.'],
            ['q' => 'Qual é a diferença entre IPv4 e IPv6?', 'a' => 'Endereços IPv4 são como 203.0.113.42 e se esgotaram na maioria das regiões. Os IPv6, como 2001:db8::1, foram criados para oferecer muito mais endereços.'],
        ],
    ],
];
