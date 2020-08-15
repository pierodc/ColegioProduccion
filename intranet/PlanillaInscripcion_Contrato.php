<?php 


$pdf->AddPage();
LetraGdeBlk($pdf);
$pdf->Cell(200 , $Ln1 , 'U.E. Colegio San Francisco de As�s' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'INSCRITO EN EL MPPE C�DIGO S0934D1507' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Los Palos Grandes, Municipio Chacao del Estado Miranda' , 0 , 1 , 'C'); 
$pdf->Ln();
$pdf->Cell(200 , $Ln1 , 'Contrato de Prestaci�n de Servicios Educativos ' , 0 , 1 , 'C'); 
$pdf->Ln();

$pdf->SetFont('Arial','',9);
$i=1;$j=2;
$Fecha_Nac = substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ;

$pdf->MultiCell(200, 3.2 ,"Entre Vita Mar�a Di Campo y Giampiero Di Campo quienes son de Nacionalidad venezolana, mayores de edad, de este domicilio, identificados con el Documento de Identidad N�6973243 y 10863540, en su car�cter de Director Acad�mico y Director de Administraci�n  de la Unidad Educativa Colegio San Francisco de Asis,  inscrito por ante el Ministerio del Poder Popular para la Educaci�n bajo el C�digo S0934D1507, ubicado en Los Palos Grandes, Municipio Chacao, del Estado Miranda, en lo adelante y a los efectos del presente contrato EL COLEGIO, por una parte; y por la otra $rep_Nombres[$i] / $rep_Nombres[$j], de nacionalidad $rep_Nacionalidad[$i] / $rep_Nacionalidad[$j], mayor de edad, de este domicilio, identificado con el Documento de Identidad N�$rep_Cedula[$i]/$rep_Cedula[$j], en lo adelante EL REPRESENTANTE LEGAL, del ni�o (a) o adolescente $Apellidos $Nombres quien es de nacionalidad $Nacionalidad, nacido en fecha $Fecha_Nac, en lo adelante EL ESTUDIANTE, se ha convenido en celebrar como en efecto se celebra el presente CONTRATO DE PRESTACION DE SERVICIOS EDUCATIVOS, el cual se regir� por la siguientes disposiciones:
PRIMERA: EL COLEGIO es una empresa de car�cter privado no subsidiada por un ente oficial, ni de la administraci�n p�blica central ni descentralizada, que presta servicios de instrucci�n, atenci�n y cuidado en general a estudiantes que as� lo soliciten, prestando sus servicios durante los d�as h�biles conforme  al calendario educativo que a tal efecto decrete el Ministerio del Poder Popular para la Educaci�n. En virtud de ello, EL COLEGIO se compromete a brindar a EL ESTUDIANTE una educaci�n de calidad, garantizar el adecuado mantenimiento de su planta f�sica, garantizar la dotaci�n de los insumos necesarios para el buen funcionamiento, as� como garantizar la contrataci�n de personal capacitado para dar cumplimiento cabal a la misi�n que tiene encomendada de �EDUCAR CON EXCELENCIA EN UN AMBIENTE DE PARTICIPACI�N, LIBRE Y RESPONSABLE�. 
SEGUNDA: Forman parte integrante del presente contrato, adem�s de las estipulaciones contenidas en el mismo, el Acuerdo de Convivencia Escolar, el cual se encuentra publicado en la p�gina web del Colegio San Francisco de As�s en Los Palos Grandes, Caracas, www.colegiosanfrancisco.com y que declara conocer y aceptar EL REPRESENTANTE LEGAL, as� como las informaciones contenidas en las solicitudes, circulares y otros instrumentos de informaci�n que sean suscritos por EL COLEGIO, EL REPRESENTANTE LEGAL y/o EL ESTUDIANTE.
TERCERA: La vigencia del presente contrato es por el t�rmino de un a�o fijo escolar, entendiendo por tal, el que inicia el 16 de septiembre de $Ano1prox y culmina el 31 de julio de $Ano2prox. 
CUARTA: El presente contrato se perfecciona una vez que EL REPRESENTANTE LEGAL, realice la inscripci�n de EL ESTUDIANTE y cancele el monto total de la matr�cula o inscripci�n, Seguro Escolar, Cuota del Consejo Educativo y la escolaridad correspondiente al mes de septiembre y el mismo sea debidamente suscrito.
QUINTA: EL COLEGIO se compromete a prestar sus servicios a EL ESTUDIANTE, empleando para ello todos sus conocimientos y dedicaci�n para el mayor �xito de las funciones que tiene encomendadas; por su parte EL REPRESENTANTE LEGAL se obliga a cumplir y hacer cumplir a EL ESTUDIANTE, todas y cada una de las estipulaciones del presente contrato, as� como el ACUERDO DE CONVIVENCIA ESCOLAR. As� mismo, EL REPRESENTANTE LEGAL en contraprestaci�n al servicio educativo que presta EL COLEGIO, se compromete a cancelar puntualmente los derechos de matr�cula y las escolaridades, correspondientes al a�o escolar previamente definido, que incluyen el pago de doce (12) cuotas mensuales y consecutivas, durante los primeros cinco (5) d�as de cada mes,  as� como cualquier otro pago adicional que se acuerde previamente en consenso con el REPRESENTANTE LEGAL. 
SEXTA: A los efectos indicados en la estipulaci�n que antecede, EL REPRESENTANTE LEGAL declara y acepta expresamente como de obligatorio cumplimiento, los montos fijados como derechos de escolaridad para el a�o escolar, los cuales podr�n ser objeto de ajustes por variaci�n de los costos, tales como: incrementos taxativos en la remuneraci�n del personal por aumentos salariales decretados por el Ejecutivo Nacional; incrementos de los servicios p�blicos, beneficios y mejoras tanto al personal  directivo, docente, administrativo y obrero como los relacionados con el mantenimiento de la planta f�sica; acuerdos de incrementos magisteriales o cualquier otro tipo de beneficio, siempre y cuando sean permitidos legalmente y as� hayan sido decretados por el Ejecutivo Nacional o por acuerdos aprobados en Asambleas de Padres y Representantes.
SEPTIMA: En caso de operar ajustes de incremento de la escolaridad y EL REPRESENTANTE LEGAL hubiere cancelado escolaridades por adelantado, una vez se determine la notificaci�n de incremento, �ste deber� pagar la respectiva diferencia.
OCTAVA: En caso de que EL REPRESENTANTE LEGAL se retrase en el pago de una o m�s escolaridades, �ste se compromete a cancelar las mismas en base al monto de la escolaridad vigente para el mes en el que efectivamente se materialice el pago. La falta de pago de dos (2) o m�s escolaridades o cuotas por parte de EL REPRESENTANTE LEGAL, dar� lugar a que EL COLEGIO, ejerza las acciones de cobro necesarias, agotando los mecanismos de mediaci�n y en caso de ser necesario por ante las instancias judiciales respectivas. 
NOVENA: Queda sobrentendido y as� declara conocerlo y aceptarlo EL REPRESENTANTE LEGAL, que para los efectos de la inscripci�n de su representado para el a�o lectivo siguiente para el cual fue efectivamente inscrito, se deber� estar solvente con todos los pagos referentes a EL COLEGIO, en el caso en que exista alg�n monto adeudado, no se proceder� a realizar el proceso de inscripci�n de su representado hasta tanto demuestre estar efectivamente solvente con EL COLEGIO.
DECIMA: Para los casos de ajustes en los montos de la escolaridad, los mismos ser�n notificados por escrito al EL REPRESENTANTE LEGAL, de conformidad con lo establecido en la normativa legal vigente y en los acuerdos emanados del seno de las Asambleas de Padres y Representantes, con la debida anticipaci�n, esto es, con al menos cinco (5) d�as de anticipaci�n. Las partes acuerdan y aceptan que las notificaciones de car�cter administrativo, acad�mico y otras vinculadas con EL COLEGIO, ser�n enviadas bien a trav�s de correo electr�nico, notificaciones personales y el servicio de mensajer�a de texto del que dispone EL COLEGIO.
DECIMA PRIMERA: En caso de resoluci�n anticipada del presente contrato o en el caso de que EL ESTUDIANTE sea retirado antes del mes de abril, inclusive, EL REPRESENTANTE LEGAL, estar� obligado a cancelar hasta la escolaridad correspondiente a la fecha del retiro y la proporci�n que corresponda al mes de agosto. De retirarlo a partir del mes de mayo deber� pagar todas las escolaridades hasta agosto; y no tendr� derecho en ambos casos, al reembolso o reintegro bajo ning�n concepto ni por ninguna causa de lo pagado por concepto de matr�cula, escolaridad, seguro escolar, mensualidades, cuota del Consejo Educativo y u otro concepto de obligatorio pago. EL REPRESENTANTE LEGAL, libera al COLEGIO de cualquier responsabilidad legal relacionada con el retiro de EL ESTUDIANTE, ocasionada por el incumplimiento de este contrato, tanto afecte a EL ESTUDIANTE como al REPRESENTANTE LEGAL.
DECIMA SEGUNDA:  EL REPRESENTANTE LEGAL se compromete a brindarle a su representado el apoyo necesario para que logre el perfil requerido por EL COLEGIO, en dicho sentido deber� velar para que EL ESTUDIANTE asista diaria y puntualmente a clases justificando oportunamente sus inasistencias, as� como garantizar el uso correcto del uniforme escolar. As� mismo, deber� asistir a todas las citaciones, reuniones y Asambleas que tanto EL COLEGIO como el Consejo Educativo efect�en a fin de que se concrete la comunicaci�n necesaria, asertiva y oportuna para lograr el desarrollo integral del ESTUDIANTE. Tanto EL REPRESENTANTE LEGAL como EL COLEGIO,  se comprometen a cumplir con los acuerdos que se generen en dichos encuentros.
DECIMA TERCERA: De conformidad con lo establecido en la Constituci�n de la Rep�blica Bolivariana de Venezuela, la Ley Org�nica de Educaci�n vigente y su reglamento, la Ley sobre la Protecci�n de Derechos de ni�os, ni�as y adolescentes y el Acuerdo de Convivencia Escolar de EL COLEGIO, el Derecho a la Educaci�n es un derecho inherente al proceso de formaci�n y crecimiento de todos los ni�os, ni�as y adolescentes, en consecuencia el REPRESENTANTE LEGAL se obliga a garantizar a EL ESTUDIANTE este derecho mediante la inscripci�n oportuna as� como los derechos conexos a este como lo son: el sustento, la habitaci�n, tiempo de recreaci�n y esparcimiento, cultura, salud, atenci�n m�dica y deportes. As� mismo, EL REPRESENTANTE LEGAL acepta las siguientes obligaciones:
�	Mantener una comunicaci�n constante con los docentes, a trav�s de las v�as formales de EL COLEGIO.
�	Acompa�ar en casa el trabajo escolar de EL ESTUDIANTE.
�	Garantizar a EL ESTUDIANTE el apoyo de especialistas externos, en caso de que fuera necesario, para su nivelaci�n y entregar oportunamente a los docentes los informes de los mismos.
�	Respetar las decisiones acad�micas propuestas por el equipo docente de EL COLEGIO, en beneficio del desarrollo integral de EL ESTUDIANTE, tales como nivelarlo acad�micamente, durante el periodo de tiempo que se considere necesario, a fin de garantizar la promoci�n del mismo con la madurez y competencias requeridas para el grado inmediato superior.
�	Atender las disposiciones que el Departamento de Orientaci�n o los docentes realicen, en cuanto al �rea socioemocional de EL ESTUDIANTE, tales como evaluaciones psicol�gicas u otras que consideren pertinentes y entregar oportunamente los resultados de sus evaluaciones.
�	Asistir a todas las reuniones a las que fuese convocado y de manera especial a las Asambleas Ordinarias y Extraordinarias de padres, madres, representantes y responsables, como punto de encuentro y de toma de decisiones con los aspectos escolares vinculantes en la formaci�n de EL ESTUDIANTE.
�	Cumplir con todos los acuerdos y compromisos adquiridos en las diversas Asambleas Escolares, Reuniones de Delegados y reuniones de otro tipo que guarden relaci�n con el �mbito escolar de EL ESTUDIANTE y donde se tomen decisiones vinculantes o relacionadas con el contexto escolar.
�	Cualquiera otra obligaci�n o responsabilidad que de conformidad con la legislaci�n vigente sea de su cumplimiento.
DECIMA CUARTA: EL COLEGIO por su parte, se compromete con EL REPRESENTANTE LEGAL y con EL ESTUDIANTE a cumplir los preceptos contemplados en la Constituci�n de la Rep�blica Bolivariana de Venezuela, la Ley Org�nica de Educaci�n vigente y su reglamento, la Ley sobre la Protecci�n de Derechos de ni�os, ni�as y adolescentes y el Acuerdo de Convivencia Escolar del Colegio San Francisco de Asis, referentes al derecho a la educaci�n y sus derechos conexos en tanto le sean aplicables como corresponsable en la formaci�n de los ni�os, ni�as y adolescentes, en este sentido asume la responsabilidad de brindarle al ESTUDIANTE, las herramientas e insumos que sean necesarios para dar cumplimiento cabal a su misi�n y en este contexto se obliga a:
�	Mantener informados a los padres y representantes del desempe�o acad�mico y socio-emocional del ESTUDIANTE, a trav�s de reuniones e informes evaluativos donde se orientar� al REPRESENTANTE LEGAL, acerca del manejo diario y ayuda del ESTUDIANTE; as� como tambi�n a recomendar, en caso de ser necesaria una nivelaci�n o apoyo con un especialista externo.
�	Mantener una comunicaci�n constante entre los docentes, Coordinaci�n y especialistas para as� trabajar en equipo, en beneficio del alumno.
�	Fomentar en el sal�n de clases, el respeto, el trabajo cooperativo y el fortalecimiento de valores de honestidad, solidaridad y tolerancia.
�	Participar en la investigaci�n pedag�gica, en la elaboraci�n y aplicaci�n de proyectos educativos con el fin de conseguir los m�s elevados niveles de excelencia.
�	Cumplir y hacer cumplir las disposiciones contempladas en la Ley Org�nica de Educaci�n, Ley Org�nica de Protecci�n de Ni�os, ni�as y adolescentes, la Constituci�n de la Rep�blica Bolivariana de Venezuela y el Acuerdo de Convivencia Escolar.
�	Notificar al REPRESENTANTE LEGAL de manera inmediata, sobre cualquier accidente o situaci�n de su representado que amerite su presencia en EL COLEGIO.
�	Cualquiera otra que de conformidad con la normativa legal vigente sea de su inter�s. 
DECIMA QUINTA: Los derechos humanos inherentes a los ni�os, ni�as y adolescentes, consagrados en la Constituci�n de la Rep�blica Bolivariana de Venezuela, la Ley Org�nica de Educaci�n y su Reglamento, la Ley Org�nica para la Protecci�n del Ni�o y del Adolescente, son parte inherente a este contrato y en consecuencia se dan aqu� por reproducidos y reconocidos y de manera particular los previstos en los art�culos:
Constituci�n de la Rep�blica Bolivariana de Venezuela: 
Art 54.- Los padres, representantes o responsables tienen la obligaci�n inmediata de garantizar la educaci�n de los ni�os y adolescentes. 
Ley Org�nica para la Protecci�n de Ni�os, ni�a y adolescente.
Art�culo 53.- Todos los ni�os, ni�as y adolescentes tienen derecho a la educaci�n. Asimismo, tienen derecho a ser inscritos y recibir educaci�n en una escuela, plantel o instituto oficial de car�cter gratuito y cercano a su residencia.
Art�culo 365. - La obligaci�n de manutenci�n comprende todo lo relativo al sustento, vestido, habitaci�n, educaci�n, cultura, asistencia y atenci�n m�dica, medicinas, recreaci�n y deportes, requeridos por el ni�o y el adolescente. 
Art�culo 366.- La obligaci�n de manutenci�n es un efecto de la filiaci�n legal o judicialmente establecida, que corresponde al padre y a la madre respecto a sus hijos que no hayan alcanzado la mayoridad. Esta obligaci�n subsiste aun cuando exista privaci�n o extinci�n de la patria potestad, o no se tenga la guarda del hijo, a cuyo efecto se fijar� expresamente por el juez el monto que debe pagarse por tal concepto, en la oportunidad que se dicte la sentencia de privaci�n o extinci�n de la patria potestad, o se dicte alguna de las medidas contempladas en el art�culo 360 de esta Ley. 
Art�culo 223 .- El obligado que incumpla injustificadamente con la obligaci�n de manutenci�n, ser� sancionado con multa de uno (1) a diez (10) meses de ingreso. 
DECIMA SEXTA: De conformidad con el art�culo 103 de la CRBV: Toda persona tiene derecho a una educaci�n integral, de calidad, permanente, en igualdad de condiciones y oportunidades, sin m�s limitaciones que las derivadas de sus aptitudes, vocaci�n y aspiraciones. La educaci�n es obligatoria en todos sus niveles, desde el maternal, hasta el nivel medio diversificado. La impartida por el Estado es gratuita hasta el pregrado universitario, queda expresamente establecido que EL REPRESENTANTE LEGAL por voluntad propia inscribe a EL ESTUDIANTE en EL COLEGIO , la cual como se estableci� anteriormente, es una instituci�n privada y no gratuita, por lo que se compromete a cancelar puntualmente las cuotas establecidas.
DECIMA SEPTIMA: Queda expresamente convenido que EL COLEGIO no se hace responsable de los da�os sufridos por los alumnos durante su permanencia en sus instalaciones que sean ocasionados por: terremotos, explosiones, inundaciones y/ o cualquier otra circunstancia de fuerza mayor o caso fortuito. 
DECIMA OCTAVA: EL COLEGIO se obliga a mantener vigente una p�liza de seguro de accidentes personales, por lo que, en caso de ocurrir alg�n siniestro. EL REPRESENTANTE LEGAL aceptar� y estar� conforme con el monto de la cobertura y condiciones de la p�liza suscrita, as� como la indemnizaci�n que acuerde la compa��a de seguro y en consecuencia, libera de toda responsabilidad a EL COLEGIO por cualquier excedente del monto cubierto, as� como de otro da�o que hubiere podido sufrir, ni por lucro cesante o da�os emergentes.
DECIMA NOVENA: Queda expresamente convenido, que EL COLEGIO, se reserva el derecho de admisi�n en sus instalaciones, de all� que EL REPRESENTANTE LEGAL no podr� enviar para retirar a EL ESTUDIANTE de EL COLEGIO, a una persona que no haya sido autorizada previamente y por escrito por EL REPRESENTANTE LEGAL. 
VIGESIMA: Queda expresamente convenido que EL COLEGIO presta servicios complementarios y/o actividades extracurriculares, por lo que en caso de ser contratados por EL REPRESENTANTE LEGAL para EL ESTUDIANTE, los mismos deber�n ser pagados aparte y de forma adicional a las escolaridad establecida por EL COLEGIO.
VIG�SIMA PRIMERA: EL REPRESENTANTE LEGAL queda enterado que las actividades tales como: educaci�n f�sica, recreo, culturales y dem�s propias del colegio se realizan tambi�n en una cancha m�ltiple ubicada a una quinta de por medio a las instalaciones de EL COLEGIO y por lo tanto autoriza a EL COLEGIO para trasladar a EL ESTUDIANTE a la misma. Adem�s, autoriza a EL ESTUDIANTE a participar en las salidas para la iglesia, comparsas, paseos  y dem�s actividades que organice el colegio seg�n la programaci�n del a�o escolar. 
VIG�SIMA SEGUNDA: Por medio del presente documento EL REPRESENTANTE LEGAL declara Si ____ / No ____ autoriza a EL ESTUDIANTE para que al finalizar las actividades escolares salga de LA INSTITUCION por sus propios medios. 
VIGESIMA TERCERA: EL REPRESENTANTE LEGAL, declara estar en conocimiento y aceptar que EL COLEGIO, est� activo en los diferentes medios de comunicaci�n  de Redes Sociales, en los cuales publica informaci�n referida al �mbito escolar, actividades recreativas, deportivas y culturales, en consecuencia, reconocen que EL COLEGIO, est� legitimado para el uso de dichas redes, donde podr� publicar sin necesidad del consentimiento de EL REPRESENTANTE LEGAL, de EL ESTUDIANTE o de sus padres, las im�genes de acontecimientos y eventos vinculadas a la funci�n educativa y que se utilizan con fines de difusi�n en la web del colegio y en las redes sociales. EL COLEGIO, se compromete a que las im�genes de ni�os, ni�as o adolescentes que se utilicen para publicar actividades educativas, no menoscaben los derechos inherentes a los ni�os, ni�as y adolescentes referentes al honor, reputaci�n, propia imagen, vida privada, intimidad familiar entre otros.
VIGESIMA CUARTA: Yo $rep_Nombres[$i] / $rep_Nombres[$j], arriba identificado, firmo en se�al de haber le�do el presente contrato de servicio y manifiesto estar conforme en todas y cada una de sus partes. 
VIGESIMA QUINTA: Al inscribir a su representado en EL COLEGIO, asumimos juntos, que nuestro inter�s superior es el ni�o. Afrontaremos m�ltiples situaciones en los cuales los criterios a utilizar se basar�n en los ideales, principios, normas institucionales y en el marco jur�dico actual.
Ambas partes declaran expresamente formalizar la inscripci�n de acuerdo a la informaci�n suministrada por EL REPRESENTANTE LEGAL en la planilla de inscripci�n anexa al presente contrato. Se hacen dos ejemplares de un mismo tenor y a un solo efecto, en Caracas a los $hoy_dia d�as del mes $hoy_mes de $hoy_ano. 


                         VITA MARIA DI CAMPO                         GIAMPIERO DI CAMPO
                         Directora Acad�mica                            Director Administrativo
",0,'J');


$pdf->SetDrawColor(0);

//$pdf->Cell(200 , $Ln2*2 , 'Firmo en se�al de haber le�do y estar conforme en todas y cada una de sus partes' , 0 , 1 , 'L'); 
foreach ($Padres as $Padre){
LetraTit($pdf);
$pdf->Cell(200 , $Ln2*2 , $Padre.' / Autorizado' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(70 , $Ln2+1 , 'Nombre' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'C�dula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 
$pdf->Cell(70 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1.2 , '' , $borde2 , 1 , 'L'); 
}


$pdf->Ln(20);
$pdf->Cell(200 , $Ln2*1.5 , 'AUTORIZACI�N' , '' , 1 , 'C'); 
$pdf->MultiCell(200 , $Ln2*1.5 , 'Yo: _________________________________________ Autorizo a mi hijo(a) a retirarse del plantel por sus propios medios luego de terminar las actividades escolares. ' , 0 , 'J'); 
$pdf->Cell(70 , $Ln2+1 , 'Fecha' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'C�dula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 

$pdf->Cell(70 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1 , '' , $borde2 , 1 , 'L'); 



$pdf->SetFont('Arial','B',10);
$pdf->Ln(20);
$pdf->Cell(200 , $Ln2 , '' , '' , 1 , 'C'); 
$pdf->Cell(80 , $Ln2*1.2 , 'Documentos que se anexan a la planilla (Copia): ' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(20 , $Ln2*1.5 , 'Part. Nac.' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Alum' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Padre' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Madre' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Autoriz' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Fotos Al.' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Ln(1);
$pdf->Ln($Ln2*2);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(48 , $Ln2*1.5 , 'Comprobante de Pago:' , 0 , 0 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(18 , $Ln2*1.5 , 'Dep�sito' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Transf.' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Cheque' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
if($row_RS_Alumno['Deuda_Actual']>0){
$pdf->Cell(55 , $Ln2*1.5 , 'Solvencia '.$row_RS_Alumno['Deuda_Actual'].'' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(23 , $Ln2*1.5 , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] , 0 , 1 , 'R'); }
else
$pdf->Cell(83 , $Ln2*1.5 , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] , 0 , 1 , 'R'); 


$pdf->Ln(2);
LetraPeq($pdf);
$pdf->Cell(50 , $Ln2*2 , 'Banco:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Fecha:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'N�m:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Monto:' , 1 , 0 , 'L'); 
$pdf->Ln($Ln2*2);
$pdf->Cell(100 , $Ln2*2 , 'Recibido por: nombre:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Firma:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Fecha:' , 1 , 0 , 'L'); 
//$pdf->Ln($Ln2*2+3);
/*
LetraPeq($pdf);
$pdf->Cell(60 , $Ln2 , '�Recibe las circulares via email? ' , 0 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'si' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'no' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , '  E-mail: _____________________________________ ' , 0 , 0 , 'L'); 
*/

?>