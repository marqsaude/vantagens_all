--
-- Dumping data for table `tb_contrato_gog`
--

INSERT INTO `tb_contrato_gog` (`co_seq_contrato_gog`, `nm_contrato_gog`, `lk_contrato_gog`, `nu_valor`, `nu_meses`, `nu_dependentes`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Fitness', 'contrato_fitness.pdf', 177.00, 12, 5, 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2),
(2, 'Teen', 'contrato_teen.pdf', 220.00, 12, 5, 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2),
(3, 'Homem', 'contrato_homem.pdf', 320.00, 12, 5, 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 1),
(4, 'Mulher', 'contrato_mulher.pdf', 540.00, 12, 5, 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2),
(5, 'Melhor Idade', 'contrato_melhor_idade.pdf', 643.00, 12, 5, 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2);


--
-- Dumping data for table `tb_empresa`
--

INSERT INTO `tb_empresa` (`co_seq_empresa`, `nm_empresa`, `nu_cnpj`, `tx_endereco`, `nu_cep`, `nu_inscricao`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Insono', '09045786000138', 'QNC 11 LOTE 05 - TAGUATINGA NORTE', '72115610', '000', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(2, 'Ineuros', '17442586000147', 'A/E 08/09/10 SETOR C NORTE TÉRREO SALA 03', '72115360', '000', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(3, 'Inside-Instituto de Saúde e Diagnostico de Brasilia', '20000108000191', 'AE 08/09 E 10, 18, 19 E 20 D TERREO', '72115700', '000', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(4, 'Densiquality Imagens', '02578847000183', 'A/E 08/09/10 SETOR C NORTE ALA D SALAS 03/04 ALA D', '72115360', '000', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(5, 'QSaúde', '00000000000000', 'QNC 11 LOTE 05 - TAGUATINGA NORTE', '72115610', '000', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_exame`
--

INSERT INTO `tb_exame` (`co_seq_exame`, `nm_exame`, `lk_img`, `lk_img_100`, `tx_exame`, `nm_width`, `nm_height`, `nm_justify`, `st_show_index`, `tipo`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'AUDIOMETRIA', 'audiometria.jpg', 'audiometria.jpg', '', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(2, 'BERA', 'exames/bera.jpg', '/site/images/nssp2_thumbs/100/bera.jpg', '<p style="text-align: justify;">Esse teste tem como objetivo avaliar a integridade do nervo auditivo, desde a orelha interna até o cortéx cerebral. Através desse processo é determinado, caso exista, a perda auditiva e também determina o tipo e o grau dessa perda. Para a realização do exame são fixados eletrodos na pele atrás das orelhas, na testa e são colocados fones.O paciente deve ficar deitado e o mais relaxado possível.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(3, 'DENSITOMETRIA ÓSSEA', 'exames/DESENTOMETRIA.jpg', '/site/images/nssp2_thumbs/100/DESENTOMETRIA.jpg', '<p style="text-align: justify;">Esse exame se baseia na dupla emissão de raios x para medir a quantidade de massa óssea que permite o diagnóstico e o tratamento da osteoporose, bem como a avaliação do risco de fratura. É indicado para pessoas com maiores fatores de risco para desenvolver a osteoporose.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(4, 'DOPPLER DE CARÓTIDAS', '616_UltrasomdeCarotidas.jpg', '/site/images/nssp2_thumbs/100/616_UltrasomdeCarotidas.jpg', '<p style="text-align: justify;">Utilizando os princípios de ultrassonografia, o exame de <strong>Doppler de Carótidas e Vertebrais</strong> é realizado com modernidade e segurança através do trabalho de profissionais capacitados e equipamentos com alto padrão de tecnologia.</p><p style="text-align: justify;"> </p><p style="text-align: justify;">Indicado para diagnóstico de doenças como aterosclerótica, este exame proporciona uma análise confiável e que facilita o trabalho dos profissionais da saúde. As artérias carótidas são importantes vasos sanguíneos que levam sangue arterial do coração para o cérebro. Elas se originam no tórax a partir da aorta, passam através do pescoço, uma de cada lado, até alcançarem e irrigarem o cérebro.</p>', '', '', '5', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(5, 'DOPPLER TRANSCRANIANO', 'exames/TRANSCRAN.jpg', '/site/images/nssp2_thumbs/100/TRANSCRAN.jpg', '<p style="text-align: justify;">Esse exame permite uma avaliação cerebrovascular de forma rápida, segura e não invasivo. O objetivo é de avaliar a circulação sanguínea dos principais vasos intracranianos, através do sistema doppler de emissão pulsada de ondas de baixa frequência.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(6, 'DOPPLER VENOSO', 'DOPLERVENOSO.jpg', '/site/images/nssp2_thumbs/100/DOPLERVENOSO.jpg', '<p style="text-align: justify;">É um exame de imagem que visa estudar as artérias ou veias. É indolor, não invasivo e inócuo, isto é, sem complicações ou efeitos laterais. Este exame permite não só a avaliação da estrutura do vaso (dimensão, presença de obstruções ou outro tipo de lesões), como também a avaliação do fluxo (direcção e velocidade).</p>', '326', '217', '', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(7, 'ECOCARDIOGRAMA COM DOPPLER', 'exames/ecodoppler.png', '/site/images/nssp2_thumbs/100/ecodoppler.png', '<p style="text-align: justify;">É um exame que utiliza ultrassom para produzir imagens do coração através de modernos aparelhos. Muito utilizado na cardiologia, é complementar no diagnóstico de uma série de doenças do coração. Com o ecocardiograma é possível avaliar o estado do órgão dos pacientes, verificando anomalias funcionais das estruturas e também anomalias morfológicas. Desta forma, pode-se verificar o fluxo de sangue nas válvulas e em vasos do coração.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(8, 'ECODOPPLER DOS MEMBROS INFERIORES', 'exames/ecodoppler_venoso.png', '/site/images/nssp2_thumbs/100/ecodoppler_venoso.png', '<p style="text-align: justify;">É um exame de imagem que visa estudar as artérias ou veias. É indolor, não invasivo e inócuo, isto é, sem complicações ou efeitos laterais. Este exame permite não só a avaliação da estrutura do vaso (dimensão, presença de obstruções ou outro tipo de lesões), como também a avaliação do fluxo (direcção e velocidade).</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 2),
(9, 'ECOGRAFIA DO ABDÔMEN', 'ecografiaab.jpg', '/site/images/nssp2_thumbs/100/ecografiaab.jpg', '<p style="text-align: justify;">A ecografia é uma excelente técnica de exame por imagem, muito simples, com diagnósticos precisos em diversos órgãos internos, músculos e partes de articulações.</p><p style="text-align: justify;">Durante o exame, para que os ultrassons não sejam perdidos, é aplicado sobre a pele, um gel de contato para aumentar a propagação do "eco". Normalmente,  são feitos vários movimentos com a sonda ecográfica em varrimentos multidirecionados sobre o órgão com eventual lesão.</p><p style="text-align: justify;">Confira abaixo os diferentes tipos de ecografias:</p><p style="text-align: justify;"><ul><li>Abdômen Superior (analisa fígado, vesícula biliar, vias biliares, pâncreas e baço. Detecta problemas como cirrose hepática, tumores do fígado, cálculos na vesícula biliar, tumores do pâncreas entre outros).</li><li>Abdômen Total (analisa todos os órgãos do abdômen superior além dos rins, retroperitônio e bexiga. Detecta tumores renais, cálculos, dilatação das vias urinárias por obstrução, tumores de bexiga, alterações na próstata entre outros).</li></ul></p>', '379', '284', '5', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(10, 'ECOGRAFIA DA TIREÓIDE', 'TIREOIDE.jpg', '/site/images/nssp2_thumbs/100/TIREOIDE.jpg', '<p style="text-align: justify;">É um método de imagem usado para observar se a tireoide (uma glândula localizada na parte anterior do pescoço), e que tem como função de regular o metabolismo. As alterações do funcionamento da tireoide são o aumento ou a redução da quantidade de hormônios no sangue – hipertireoidismo ou hipotireoidismo, respectivamente.</p>', '252', '188', '', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(11, 'ECOGRAFIA MAMÁRIA', 'ecografia mamaria.jpg', '/site/images/nssp2_thumbs/100/ecografia mamaria.jpg', '<p style="text-align: justify;">A ecografia mamária é um exame de ecografia destinado ao estudo da mama. É um ótimo exame para estudo das glândulas. É de grande importância como complemento da mamografia, especialmente, em mamas de elevada densidade radiológica ou para ajudar a esclarecer algumas alterações observadas na mamografia.</p><p style="text-align: justify;">Muitas vezes, detecta pequenas lesões (até mesmo cancros), antes de serem detectados, clinicamente, ou por vezes até ocultos na mamografia.</p>', '', '', '', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(12, 'ECOGRAFIA TRANSVAGINAL', 'curso_transvaginal_doppler.jpg', '/site/images/nssp2_thumbs/100/curso_transvaginal_doppler.jpg', '<p style="text-align: justify;">A ecografia é amplamente usada na monitorização da indução da ovulação e nos procedimentos de reprodução assistida. A ecografia é um método de imagem para exame dos órgãos internos por meio de ondas sonoras de alta freqüência. A ecografia geralmente não é  usada como controle da ovulação normal, mas é utilizada principalmente para verificar os efeitos dos tratamentos hormonais.</p>\r\n                                            <p style="text-align: justify;">Neste método, um transdutor de ecografia é posicionado no interior da vagina. Não é necessário que a bexiga esteja cheia para este procedimento, tornando-o mais confortável para a paciente, porque o transdutor transvaginal está muito próximo dos órgãos que serão examinados. O exame ecográfico é frequentemente realizado quando se faz o exame pélvico para avaliação cervical. Da mesma forma que possibilita um melhor diagnóstico, a ecografia transvaginal é preferida pelas pacientes, pois é muito mais confortável e conveniente do que o exame ecográfico abdominal. O transdutor transvaginal revolucionou o campo de tratamento de infertilidade, porque a introdução da ecografia de alta freqüência diretamente no interior da vagina permite a visualização do colo, cavidade uterina, ovários e tubas de Falópio com grande clareza e resolução de detalhes.</p>\r\n                                            <p style="text-align: justify;">Uma utilização importante da ecografia transvaginal é a observação dos folículos ováricos em desenvolvimento. A observação direta dos ovários pode ser útil no diagnóstico da síndrome do ovário poliquístico (PCOS), que é caracterizada por quistos foliculares múltiplos na superfície do ovário. Esta técnica também possibilita monitorização segura e conveniente da indução da ovulação, permitindo ao médico observar o desenvolvimento dos folículos ovárianos em resposta à terapêutica hormonal.</p>', '', '', '5', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(13, 'ELETROCARDIOGRAMA', 'exames/eletrocardiograma.png', '/site/images/nssp2_thumbs/100/eletrocardiograma.png', '<p style="text-align: justify;">O eletrocardiograma (ECG) é um exame que verifica a existência de problemas com a atividade elétrica do coração. É um procedimento rápido, simples e indolor, no qual os impulsos elétricos do coração são amplificados e registrados em um pedaço de papel.</p><p style="text-align: justify;">O eletrocardiograma (ECG) é um exame que verifica a existência de problemas com a atividade elétrica do coração. É um procedimento rápido, simples e indolor, no qual os impulsos elétricos do coração são amplificados e registrados em um pedaço de papel.</p><p style="text-align: justify;">Geralmente, um ECG é pedido se houver suspeita de uma doença cardíaca ou como parte de um exame físico de rotina para a maioria das pessoas de meia-idade e mais velhas.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(14, 'ELETROENCEFALOGRAMA PROLONGADO', 'exames/eletro.jpg', '/site/images/nssp2_thumbs/100/eletro.jpg', '<p style="text-align: justify;">Como o EEG simples, este exame serve para registrar a atividade elétrica cerebral,através da colocação de eletrodos diretamente no couro cabeludo do paciente e através de cabos,tais informações são levadas a um computador que registra. O exame prolongado está indicado quando o EEG de rotina (que tem um curto tempo de registro) não é suficiente para registrar anormalidades na atividade elétrica cerebral. Durante o registro prolongado,dá-se oportunidades para o registro de anormalidades eventuais e aquelas que aparecem durante períodos específicos do sono. É muito usado nos serviços de Cirurgia de Epilepsia,quando se interna o paciente durante até mais de 100 horas, e, até pode-se utilizar estímulos que facilitam o aparecimento de uma crise epiléptica, com finalidade de registrar a área de origem das descargas epeileptogênicas e indicar uma cirurgia precisa.</p>', '', '', '5', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(15, 'ELETRONEUROMIOGRAFIA', 'exames/eletroneuromiografia.jpg', '/site/images/nssp2_thumbs/100/eletroneuromiografia.jpg', '<p style="text-align: justify;">É um método de diagnóstico neurofisiológico usado na avaliação diagnóstica e prognostica das doenças dos nervos periféricos, plexos, raízes, neurônios motores espinhais, além dos músculos e junções neuromusculares.</p><p style="text-align: justify;">São poucas as contraindicações para o exame, presença de marca-passo cardíaco (eletroneurografia), uso de anticoagulantes (eletromiografia)</p><p style="text-align: justify;">Indicações da eletroneurografia:</p><p style="text-align: justify;">Doenças do Neurônio Motor:</p><ul><li>Esclerose lateral amiotrófica</li><li>Esclerose lateral primária</li><li>Atrofia muscular progressiva</li><li>Poliomielite (paralisia infantil)</li><li>Atrofia muscular espinhal</li><li>Doença de Kennedy</li><li>Amiotrofia monomélica</li></ul><p style="text-align: justify;">Doenças das Raízes Espinhais</p> <ul><li>Radiculopatias (hérnia de disco)</li><li>Polirradiculopatias (diabetes, inflamação, artrose da coluna)</li></ul> <p style="text-align: justify;">Doenças dos Plexos</p> <ul><li>Plexopatia braquial</li><li>Síndrome do desfiladeiro torácico neurogênica verdadeira</li><li>Plexopatia lombossacral</li></ul> <p style="text-align: justify;">Doenças dos Nervos Periféricos</p> <ul><li>Polineuropatias axonais e desmielinizantes</li><li>Mononeuropatias (Túnel do Carpo, Paralisia Facial)</li><li>Trauma de nervos periférico</li><li>Mononeuropatias múltiplas</li></ul> <p style="text-align: justify;">Doenças da Transmissão Neuromuscular</p> <ul><li>Miastenia gravis</li><li>Síndrome miastênica de Lambert Eaton</li><li>Botulismo</li><li>Intoxicação por organofosforados</li></ul> <p style="text-align: justify;">Doenças dos Músculos</p> <ul><li>Miopatias</li><li>Distrofias musculares</li><li>Paralisias periódicas</li></ul>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(16, 'ESPIROMETRIA (PROVAS DE FUNÇÃO PULMONAR)', 'exames/espiro.jpg', '/site/images/nssp2_thumbs/100/espiro.jpg', '<p style="text-align: justify;">Esse teste mede a quantidade de ar que entra e sai dos pulmões,através dos testes de função pulmonar,quando orienta-se o paciente a realizar algumas respirações,que serão captadas por um equipamento ligado a um computador, onde ocorre os cálculos de todas as informações da respiração naquele momento. Através desse exame,pode ser detectado vários problemas relacionados com a respiração,e sugere se o problema é originado nos pulmões, nas vias aéreas superiores, na restrição à respiração por doenças musculares ou ortopédicas, etc.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(17, 'HOLTER E MAPA 24 HORAS', 'exames/mapa24.png', '/site/images/nssp2_thumbs/100/mapa24.png', '<p style="text-align: justify;">HOLTER</p><p></p><p style="text-align: justify;">O Holter é um monitor portátil, que registra a atividade elétrica do coração e suas variações durante as 24 horas do dia ou mais e pode, assim, detectar alterações que em geral não aparecem num exame de tempo mais limitado, como num eletrocardiograma simples, por exemplo. Na verdade, o Holter é um eletrocardiograma para ser lido posteriormente.</p><p></p><p style="text-align: justify;">MAPA - Monitorização de Pressão Arterial em 24 horas</p><p style="text-align: justify;">Com a monitorização ambulatorial da pressão arterial (MAPA) a pressão arterial é, automaticamente, medida e registrada a cada vinte minutos, nas 24 horas do dia, durante a vigília e o sono. Ela permite, então, analisar o comportamento da pressão arterial, durante os vários eventos do cotidiano, da pessoa e ainda torna possível avaliar a eficácia de tratamentos anti-hipertensivos, quando é o caso.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(18, 'MAPEAMENTO CEREBRAL', 'exames/mapeamentp.jpg', '/site/images/nssp2_thumbs/100/mapeamentp.jpg', '<p style="text-align: justify;">Mapeamento Cerebral utiliza dados obtidos do eletroencefalograma,que avalia a quantidade de atividade elétrica de uma determinada região do cérebro de forma quantitativa com interpolação de dados e proporciona uma avaliação mais precisa da atividade elétrica cerebral, dando uma visão gráfica mais apurada da localização de alterações da referida atividade,através de demonstração e exposição de histogramas e mapa de valores. O equipamento que realiza o exame também proporciona animações dinâmicas das imagens cerebrais, facilitando o estudo da função cerebral e do cérebro em ação. Atualmente,as principais indicações do MC são determinar alterações que podem indicar a localização precisa de tumores cerebrais, bem como a localização precisa de doenças focais do cérebro, incluindo entre elas a epilepsia, as alterações vasculares e derrames. Em psiquiatria, o EEG Quantitativo tem sido usado para estabelecer diferenças entre vários diagnósticos, tais como a hiperatividade e os distúrbios da atenção em crianças, as demências senis ou não, a atrofia cerebral, a esquizofrenia, e até alguns casos de depressão. Em neurologia o EEG Quantitativo, além dos focos epilépticos,é útil na monitoração da abstinência de drogas, em infecções do cérebro, nos estados de coma, de narcolepsia e no acompanhamento pós-operatório de pacientes que foram submetidos à cirurgia cerebral. O tempo de realização do exame é váriável e depende da indicação do tempo do EEG.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(19, 'POLISSONOGRAFIA BASAL', 'exames/polisobasal.jpg', '/site/images/nssp2_thumbs/100/polisobasal.jpg', '<p style="text-align: justify;">A polissonografia é o principal método para investigação e diagnóstico dos distúrbios do sono. Utilizado para avaliar o sono espontâneo de um indivíduo, preferencialmente,em ambiente apropriado como clínicas especializadas e hospitais, durante uma noite inteira. Durante o exame,registra-se múltiplas variáveis fisiológicas e dos fenômenos que ocorrem durante o sono,tais como:o eletroencefalograma(EEG);eletrooculograma(EOG);eletromiografia do mento(EMG);movimentos de membros inferiores;fluxo aéreo nasal e oral; movimentos respiratórios;saturação da oxihemoglobina;eletrocardiograma e etc Coloca-se eletrodos no couro cabeludo de acordo com um sistema convencional conhecido como sistema 10-20 de colocação de eletrodos , para registro do EEG com determinação e definição dos estágios do sono e eventuais anormalidades,estágios específicos e em alguns casos descargas epilépticas.O registro da movimentação dos olhos durante o sono é realizado colocando-se eletrodos, lateralmente, a cada fenda palpebral, para captar os movimentos oculares horizontais e verticais que ocorrem, principalmente, durante o período de sonhos conhecido como sono REM. Os eletromiogramas do mento e de pernas registrados, durante o exame, são muito importantes para estagiamento do sono REM, quando ocorre atonia muscular,na definição de presença de bruxismo,contração dos masseteres e movimentação de pernas. O fluxo aéreo registrado é importante para se definir a diminuição ou cessação do fluxo aéreo para as vias aéreas inferiores, relacionados com as pausas respiratórias (Apnéias) de origem central e obstrutiva que ocorrem no sono. O ECG registra as variações na frequência e ritmo cardíaco. É importante que o exame seja monitorado por vídeo, principalmente, para determinação de alterações comportamentais, durante o sono,e de movimentos anormais,assim como,de eventuais crises epiléticas.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(20, 'POLISSONOGRAFIA COM CPAP', 'exames/polisocapp.jpg', '/site/images/nssp2_thumbs/100/polisocapp.jpg', '<p style="text-align: justify;">O exame de Polissonografia para adaptação de uma prótese ventilatória CPAPBIPAP é realizado após o exame de Polissonografia basal e determinado o diagnóstico de Síndrome de Apnéias Obstrutiva do Sono, Apnéia Central, Síndrome de Aumento na Resistência das Vias Aéreas superiores(RAVAS ou RERA) ou Ronco Primário com intensa queixa clínica. O procedimento geral é o mesmo de uma basal, exceto pela adição da prótese ventilatória(geralmente um CPAP manual). Também pode ser realizado na segunda metade da noite em que está realizando uma polissonografia basal(este método é conhecido como SPLIT NIGTH). A titulação da pressão da prótese é gradativa até a obtenção de uma pressão suficiente para abolir os distúrbios respiratórios do sono.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(21, 'POTENCIAIS EVOCADOS (P300)', 'exames/p300.jpg', '/site/images/nssp2_thumbs/100/p300.jpg', '<p style="text-align: justify;">O P300 é um Potencial Evocado Auditivo denominado potencial endógeno por refletir o uso funcional que o indivíduo faz do estímulo auditivo, sendo altamente dependente das habilidades cognitivas, entre elas atenção e discriminação auditiva. É um procedimento de avaliação objetiva, mas que depende da experiência do avaliador em detectar os picos das ondas, sendo importante a utilização de métodos de registro que facilitem a análise da presença de resposta e a interpretação dos resultados. Está indicado nos pacientes que têm dificuldades de aprendizado, de memória, uso de medicamentos depressores do SNC, crianças hiperativas e desatentas e nos idosos com proplemas cognitivos e com doenças cerebrais degenerativas.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(22, 'TERMOGRAFIA', 'exames/termografia.jpg', '/site/images/nssp2_thumbs/100/termografia.jpg', '<p style="text-align: justify;">É uma técnica de registro gráfico das temperaturas da superfície da pele, usando uma câmera infravermelha de alto desempenho. O aparelho detecta a radiação infravermelha (calor) emitida pelo corpo, podendo refletir uma fisiologia normal ou anormal. Uma cor é atribuída baseada na temperatura registrada naquela parte da pele. Não apresenta riscos, é, altamente, precisa e as imagens saem quase instantaneamente. Isto faz da termografia infravermelha uma ferramenta muito útil para o médico na hora de diagnosticar, tratar e fazer prognósticos. É 100% seguro. Não envolve radiação. Não tem dor. Não é invasiva.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 2),
(23, 'TESTE DE MÚLTIPLAS LATÊNCIAS DO SONO', 'exames/potencial.jpg', '/site/images/nssp2_thumbs/100/potencial.jpg', '<p style="text-align: justify;">Indicado nos pacientes com queixas de períodos de sono incontrolável diurno, sonolência excessiva diurna , e de outras hipersonias.<br /> O teste inicia pela manhã e é dado 5 oportunidades de 20 minutos , cada , para o paciente dormir , ao longo do dia , com período de 2 horas entre cada oportunidade. Durante cada registro de 20 minutos , avalia-se EEG em 4 canais , Eletrooculograma , eletromiograma, eletrocardiograma e 2 canais .<br /> Em cada oportunidade oferecida para o paciente dormir é analisado o estágio do sono alcançado pelo paciente, o tempo que transcorreu para seu início (latência do sono) e se ocorreu sono REM assim como sua latência. Avalia-se o aparecimento do sono REM nas 5 oportunidades com registro. É,praticamente,indispensável para o diagnóstico de Narcolepsia, pois na ocorrência de dois sonos REM durante as cinco oportunidades para dormir, pode-se presumir esse diagnóstico conforme os dados clínicos do paciente.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1),
(24, 'VECTOELETRONISTAGMOGRAFIA (VENG)', 'exames/veng.jpg', '/site/images/nssp2_thumbs/100/veng.jpg', '<p style="text-align: justify;">A VECTOELETRONISTAGMOGRAFIA é parte fundamental da rotina da avaliação otoneurológica e,através de diversas provas,visa analisar de forma minuciosa os sistemas envolvidos na manutenção do equilíbrio corporal,ou seja,na tríade composta por sistema vestibular(orelha interna e suas inter-relações com tronco encefálico e cerebelo), sistema visual/ocular(olhos e suas inter-relações com SNC) e sistema propioceptivo(músculos, articulações, tendões), auxiliando na identificação de possíveis alterações do sistema vestibular(equilíbrio), incluindo as doenças do labirinto, popularmente conhecidas como labirintites.</p>', '', '', '8', 1, 'exame', 'Tony Anderson', '2015-08-06 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_forma_pagamento`
--

INSERT INTO `tb_forma_pagamento` (`co_seq_forma_pagamento`, `nu_vezes`, `nm_forma_pagamento`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 10, 'Boleto', 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 1),
(2, 5, 'PayPal', 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2),
(3, 6, 'PagSeguro', 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 1),
(4, 12, 'Cartão de Crédito', 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2),
(5, 1, 'Cartão de Débito', 'Tony Anderson', '2017-04-06 00:00:00', NULL, NULL, 2);


--
-- Dumping data for table `tb_tipo_cliente`
--

INSERT INTO `tb_tipo_cliente` (`co_seq_tipo_cliente`, `nm_tipo_cliente`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Cartão', 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_tipo_dependentes`
--

INSERT INTO `tb_tipo_dependentes` (`co_seq_tipo_dependentes`, `nm_tipo_dependente`, `st_agregado`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Esposo(a)', 2, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(2, 'Filho(a)', 2, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(3, 'Pai', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(4, 'Mãe', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(5, 'Primo(a)', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(6, 'Irmão(a)', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(7, 'Amigo(a)', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(8, 'Outro', 1, 'Tony Anderson', '2017-04-13 00:00:00', NULL, NULL, 1),
(9, 'Titular', 2, 'Tony Anderson', '2017-08-01 00:00:00', NULL, NULL, 2);


--
-- Dumping data for table `tb_tipo_usuario`
--

INSERT INTO `tb_tipo_usuario` (`co_seq_tipo_usuario`, `nm_tipo_usuario`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'master', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(2, 'coordenador', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(3, 'funcionário', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(4, 'cliente', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(5, 'vendedor', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_usuario`
--

INSERT INTO `tb_usuario` (`co_seq_usuario`, `co_tipo_usuario`, `nm_usuario`, `nm_login`, `nm_senha`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 'Tony', 'tabx', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(2, 2, 'Coordenador 1', 'coordenador1', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(3, 3, 'Funcionário 1', 'funcionario1', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(4, 4, 'Visualizador 1', 'visualizador1', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(5, 1, 'Sistema', 'sistema', 't333t23', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(6, 5, 'Vendedor 1', 'vendedor1', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(7, 5, 'Vendedor 2', 'vendedor2', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1),
(8, 5, 'Vendedor 3', 'vendedor3', '1qaz', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_cep`
--

INSERT INTO `tb_cep` (`co_seq_cep`, `nu_cep`, `nm_logradouro`, `nm_bairro`, `nm_localidade`, `nm_uf`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 72010050, 'C5', 'Taguatinga Centro(Taguatinga)', 'Brasília', 'DF', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_cliente`
--

INSERT INTO `tb_cliente` (`co_seq_cliente`, `co_usuario`, `co_usuario_registrou`, `co_empresa`, `co_cep`, `co_tipo_cliente`, `st_muda_senha`, `tp_sexo`, `nm_cliente`, `nm_login`, `nm_senha`, `dt_nascimento`, `nu_rg`, `nu_cpf`, `nm_email`, `st_cliente`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 5, 1, 1, 1, 2, 'M', 'Tony Anderson', 'tabx', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(2, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 1', 'teste1', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(3, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 2', 'teste2', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(4, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 3', 'teste3', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(5, 1, 6, 1, NULL, 1, 2, 'M', 'Teste 4', 'teste4', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(6, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 5', 'teste5', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(7, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 6', 'teste6', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(8, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 7', 'teste7', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(9, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 8', 'teste8', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(10, 1, 6, 1, NULL, 1, 2, 'M', 'Teste 9', 'teste9', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(11, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 10', 'teste10', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(12, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 11', 'teste11', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(13, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 12', 'teste12', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(14, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 13', 'teste13', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(15, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 14', 'teste14', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(16, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 15', 'teste15', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(17, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 16', 'teste16', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(18, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 17', 'teste17', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(19, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 18', 'teste18', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(20, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 19', 'teste19', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(21, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 20', 'teste20', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(22, 3, 5, 1, NULL, 1, 2, 'M', 'Teste 21', 'teste21', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(23, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 22', 'teste22', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(24, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 23', 'teste23', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1),
(25, 1, 5, 1, NULL, 1, 2, 'M', 'Teste 24', 'teste24', '1qaz', '1986-11-24', '2484016', '00702786101', 'tabx.php@gmail.com', 1, 'Tony', '2017-03-29 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_status_pagamento`
--

INSERT INTO `tb_status_pagamento` (`co_seq_status_pagamento`, `nm_status_pagamento`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(0, 'Pendente', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(1, 'Aguardando pagamento', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 'Em análise', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 'Pago', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(4, 'Disponível', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(5, 'Em disputa', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(6, 'Devolvida', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(7, 'Cancelada', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_caixa`
--

INSERT INTO `tb_caixa` (`co_seq_caixa`, `co_empresa`, `co_cliente`, `nm_caixa`, `nu_saldo`, `nu_procedimento`, `st_ativo`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 5, NULL, 'Caixa QSaúde', 25.3, 0, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 1, NULL, 'Caixa Insono', 0.00, 0, 2, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_estado`
--

INSERT INTO `tb_estado` (`co_seq_estado`, `nm_estado`, `nm_uf`, `nm_ibge`, `nm_sl`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Acre', 'AC', 12, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 'Alagoas', 'AL', 27, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 'Amazonas', 'AM', 13, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(4, 'Amapá', 'AP', 16, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(5, 'Bahia', 'BA', 29, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(6, 'Ceará', 'CE', 23, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(7, 'Distrito Federal', 'DF', 53, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(8, 'Espírito Santo', 'ES', 32, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(9, 'Goiás', 'GO', 52, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(10, 'Maranhão', 'MA', 21, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(11, 'Minas Gerais', 'MG', 31, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(12, 'Mato Grosso do Sul', 'MS', 50, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(13, 'Mato Grosso', 'MT', 51, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(14, 'Pará', 'PA', 15, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(15, 'Paraíba', 'PB', 25, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(16, 'Pernambuco', 'PE', 26, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(17, 'Piauí', 'PI', 22, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(18, 'Paraná', 'PR', 41, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(19, 'Rio de Janeiro', 'RJ', 33, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(20, 'Rio Grande do Norte', 'RN', 24, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(21, 'Rondônia', 'RO', 11, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(22, 'Roraima', 'RR', 14, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(23, 'Rio Grande do Sul', 'RS', 43, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(24, 'Santa Catarina', 'SC', 42, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(25, 'Sergipe', 'SE', 28, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(26, 'São Paulo', 'SP', 35, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(27, 'Tocantins', 'TO', 17, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(28, 'Exterior', 'EX', 99, NULL, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_ddd`
--

INSERT INTO `tb_ddd` (`co_seq_ddd`, `co_estado`, `nu_ddd`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 68, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 2, 82, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 3, 97, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(4, 3, 92, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(5, 4, 96, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(6, 5, 77, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(7, 5, 75, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(8, 5, 73, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(9, 5, 74, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(10, 5, 71, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(11, 6, 88, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(12, 6, 85, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(13, 7, 61, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(14, 8, 28, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(15, 8, 27, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(16, 9, 62, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(17, 9, 64, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(18, 9, 61, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(19, 10, 99, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(20, 10, 98, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(21, 11, 34, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(22, 11, 37, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(23, 11, 31, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(24, 11, 33, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(25, 11, 35, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(26, 11, 38, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(27, 11, 32, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(28, 12, 67, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(29, 13, 65, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(30, 13, 66, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(31, 14, 91, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(32, 14, 94, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(33, 14, 93, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(34, 15, 83, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(35, 16, 81, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(36, 16, 87, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(37, 17, 89, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(38, 17, 86, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(39, 18, 43, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(40, 18, 41, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(41, 18, 42, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(42, 18, 44, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(43, 18, 45, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(44, 18, 46, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(45, 19, 24, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(46, 19, 22, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(47, 19, 21, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(48, 20, 84, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(49, 21, 69, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(50, 22, 95, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(51, 23, 53, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(52, 23, 54, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(53, 23, 55, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(54, 23, 51, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(55, 24, 47, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(56, 24, 48, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(57, 24, 49, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(58, 25, 79, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(59, 26, 11, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(60, 26, 12, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(61, 26, 13, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(62, 26, 14, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(63, 26, 15, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(64, 26, 16, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(65, 26, 17, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(66, 26, 18, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(67, 26, 19, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(68, 26, 19, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(69, 27, 63, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(70, 28, 100, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_consulta`
--

INSERT INTO `tb_consulta` (`co_seq_consulta`, `nm_consulta`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Nutricionista', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 'Pneumologista', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_procedimento`
--

INSERT INTO `tb_procedimento` (`co_seq_procedimento`, `co_exame`, `co_consulta`, `co_laboratorio`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1000, 1, NULL, NULL, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(1001, NULL, 1, NULL, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_tipo_prestador`
--

INSERT INTO `tb_tipo_prestador` (`co_seq_tipo_prestador`, `nm_tipo_prestador`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Médico', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 'Nutricionista', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 'Fonoaudiólogo', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(4, 'Psicólogo', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_telefone`
--

INSERT INTO `tb_telefone` (`co_seq_telefone`, `co_ddd`, `nu_telefone`, `nu_ddd`, `tp_telefone`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, '98764642', 68, 'C', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 1, '35656776', 68, 'T', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 1, '99908877', 68, 'W', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `rl_cliente_telefone`
--

INSERT INTO `rl_cliente_telefone` (`co_seq_cliente_telefone`, `co_cliente`, `co_telefone`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 1, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 1, 2, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 1, 3, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_acordo`
--

INSERT INTO `tb_acordo` (`co_seq_acordo`, `co_contrato_gog`, `co_cliente`, `co_usuario`, `lk_contrato_assinatura`, `dt_finaliza`, `dt_acordo`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 3, 1, 1, NULL, '2018-08-24', '2017-08-24', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_pagamento`
--

INSERT INTO `tb_pagamento` (`co_seq_pagamento`, `co_acordo`, `co_forma_pagamento`, `co_status_pagamento`, `nu_vezes`, `tx_id_pagseguro`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 3, 1, NULL, '4300D329FC2F45CDAF577A925D5AE5B6', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_extrato`
--

INSERT INTO `tb_extrato` (`co_seq_extrato`, `co_pagamento`, `co_caixa`, `nu_saldo`, `nu_valor_transacao`, `tp_transacao`, `st_pagamento`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 1, 25.3, 4.56, 1, 2, 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_configuracao`
--

INSERT INTO `tb_configuracao` (`co_seq_configuracao`, `co_usuario`, `co_tipo_usuario`, `tx_email_cadastro`, `nm_email_login_cadastro`, `nm_email_senha_cadastro`, `nm_email_port_cadastro`, `nm_email_smtp_cadastro`, `nm_url_sistema`, `nm_url_absoluta`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 1, '<br/><br/><center><h2>Cadastro efetuado com sucesso</h2></center><br/><br/><p align="justify">???, seu cadastro foi realizado com sucesso, para inserir sua senha, clique no link que segue -><a href="???/cliente/senha/code/???">INSERIR SENHA</a>.</p><p><br/><br/><br/><br/><br/><br/></p><p><h3><font color=''#742021''>QSaúde Card para você!</font></h3></p>', 'marqsaude@marqsaude.com.br', 'pllck@oo8mc2a', '465', 'mail.marqsaude.com.br', 'http://192.168.20.25:8888/qsaude/public_html', '/Applications/MAMP/htdocs/qsaude/public_html', 'Tony Anderson', '2015-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_parceiro`
--

INSERT INTO `tb_parceiro` (`co_seq_parceiro`, `nm_parceiro`, `nm_site`, `lk_parceiro`, `tx_sobre`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 'Athletica', 'www.marqsaude.com.brr', 'athletica_p.jpg', 'Clínica Athletica esportiva para consultas de endocrinologista.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(2, 'Clínica dos Olhos', 'www.marqsaude.com.br', 'clinica_olhos.png', 'Clínica dos olhos e etc...', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(3, 'Densiquality', 'www.densiquality.com.br', 'densiquality.jpg', 'Clínica que faz exames como Densitometria Óssea e Espirometria e etc...', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(4, 'Ineuros', 'www.ineuros.com.br', 'ineuros.jpg', 'Clínica de estudo do cerebro.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(5, 'Inside', 'www.inside.com.br', 'inside.jpg', 'Clínica de estudo do cerebro.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(6, 'Insono',  'www.insono.com.br', 'insono.jpg', 'Clínica de estudo do sono.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(7, 'MasterClin', 'www.marqsaude.com.br', 'masterclin.jpg', 'Colocado só para preenchimento.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(8, 'Olhos Anchieta', 'www.marqsaude.com.br', 'olhos_anchieta.jpg', 'Clínica de estudo dos olhos.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1),
(9, 'Patio', 'www.patiosaude.com.br', 'patio.jpg', 'Clínica colocada para preenchimento, todos os textos precisam ser alterados depois.', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);


--
-- Dumping data for table `tb_servicos`
--

INSERT INTO `tb_servicos` (`co_seq_servicos`, `co_usuario`, `nm_servicos`, `tx_servicos`, `lk_servicos`, `nm_inclusao`, `dt_inclusao`, `nm_alteracao`, `dt_alteracao`, `st_registro`) VALUES
(1, 1, 'Exames', 'Você pode utilizar seu cartão para fazer exames.', 'exames.png', 'Tony Anderson', '2017-08-24 00:00:00', NULL, NULL, 1);
