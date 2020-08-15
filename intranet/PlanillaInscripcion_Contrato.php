<?php 


$pdf->AddPage();
LetraGdeBlk($pdf);
$pdf->Cell(200 , $Ln1 , 'U.E. Colegio San Francisco de Asís' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'INSCRITO EN EL MPPE CÓDIGO S0934D1507' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Los Palos Grandes, Municipio Chacao del Estado Miranda' , 0 , 1 , 'C'); 
$pdf->Ln();
$pdf->Cell(200 , $Ln1 , 'Contrato de Prestación de Servicios Educativos ' , 0 , 1 , 'C'); 
$pdf->Ln();

$pdf->SetFont('Arial','',9);
$i=1;$j=2;
$Fecha_Nac = substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ;

$pdf->MultiCell(200, 3.2 ,"Entre Vita María Di Campo y Giampiero Di Campo quienes son de Nacionalidad venezolana, mayores de edad, de este domicilio, identificados con el Documento de Identidad N°6973243 y 10863540, en su carácter de Director Académico y Director de Administración  de la Unidad Educativa Colegio San Francisco de Asis,  inscrito por ante el Ministerio del Poder Popular para la Educación bajo el Código S0934D1507, ubicado en Los Palos Grandes, Municipio Chacao, del Estado Miranda, en lo adelante y a los efectos del presente contrato EL COLEGIO, por una parte; y por la otra $rep_Nombres[$i] / $rep_Nombres[$j], de nacionalidad $rep_Nacionalidad[$i] / $rep_Nacionalidad[$j], mayor de edad, de este domicilio, identificado con el Documento de Identidad N°$rep_Cedula[$i]/$rep_Cedula[$j], en lo adelante EL REPRESENTANTE LEGAL, del niño (a) o adolescente $Apellidos $Nombres quien es de nacionalidad $Nacionalidad, nacido en fecha $Fecha_Nac, en lo adelante EL ESTUDIANTE, se ha convenido en celebrar como en efecto se celebra el presente CONTRATO DE PRESTACION DE SERVICIOS EDUCATIVOS, el cual se regirá por la siguientes disposiciones:
PRIMERA: EL COLEGIO es una empresa de carácter privado no subsidiada por un ente oficial, ni de la administración pública central ni descentralizada, que presta servicios de instrucción, atención y cuidado en general a estudiantes que así lo soliciten, prestando sus servicios durante los días hábiles conforme  al calendario educativo que a tal efecto decrete el Ministerio del Poder Popular para la Educación. En virtud de ello, EL COLEGIO se compromete a brindar a EL ESTUDIANTE una educación de calidad, garantizar el adecuado mantenimiento de su planta física, garantizar la dotación de los insumos necesarios para el buen funcionamiento, así como garantizar la contratación de personal capacitado para dar cumplimiento cabal a la misión que tiene encomendada de “EDUCAR CON EXCELENCIA EN UN AMBIENTE DE PARTICIPACIÓN, LIBRE Y RESPONSABLE”. 
SEGUNDA: Forman parte integrante del presente contrato, además de las estipulaciones contenidas en el mismo, el Acuerdo de Convivencia Escolar, el cual se encuentra publicado en la página web del Colegio San Francisco de Asís en Los Palos Grandes, Caracas, www.colegiosanfrancisco.com y que declara conocer y aceptar EL REPRESENTANTE LEGAL, así como las informaciones contenidas en las solicitudes, circulares y otros instrumentos de información que sean suscritos por EL COLEGIO, EL REPRESENTANTE LEGAL y/o EL ESTUDIANTE.
TERCERA: La vigencia del presente contrato es por el término de un año fijo escolar, entendiendo por tal, el que inicia el 16 de septiembre de $Ano1prox y culmina el 31 de julio de $Ano2prox. 
CUARTA: El presente contrato se perfecciona una vez que EL REPRESENTANTE LEGAL, realice la inscripción de EL ESTUDIANTE y cancele el monto total de la matrícula o inscripción, Seguro Escolar, Cuota del Consejo Educativo y la escolaridad correspondiente al mes de septiembre y el mismo sea debidamente suscrito.
QUINTA: EL COLEGIO se compromete a prestar sus servicios a EL ESTUDIANTE, empleando para ello todos sus conocimientos y dedicación para el mayor éxito de las funciones que tiene encomendadas; por su parte EL REPRESENTANTE LEGAL se obliga a cumplir y hacer cumplir a EL ESTUDIANTE, todas y cada una de las estipulaciones del presente contrato, así como el ACUERDO DE CONVIVENCIA ESCOLAR. Así mismo, EL REPRESENTANTE LEGAL en contraprestación al servicio educativo que presta EL COLEGIO, se compromete a cancelar puntualmente los derechos de matrícula y las escolaridades, correspondientes al año escolar previamente definido, que incluyen el pago de doce (12) cuotas mensuales y consecutivas, durante los primeros cinco (5) días de cada mes,  así como cualquier otro pago adicional que se acuerde previamente en consenso con el REPRESENTANTE LEGAL. 
SEXTA: A los efectos indicados en la estipulación que antecede, EL REPRESENTANTE LEGAL declara y acepta expresamente como de obligatorio cumplimiento, los montos fijados como derechos de escolaridad para el año escolar, los cuales podrán ser objeto de ajustes por variación de los costos, tales como: incrementos taxativos en la remuneración del personal por aumentos salariales decretados por el Ejecutivo Nacional; incrementos de los servicios públicos, beneficios y mejoras tanto al personal  directivo, docente, administrativo y obrero como los relacionados con el mantenimiento de la planta física; acuerdos de incrementos magisteriales o cualquier otro tipo de beneficio, siempre y cuando sean permitidos legalmente y así hayan sido decretados por el Ejecutivo Nacional o por acuerdos aprobados en Asambleas de Padres y Representantes.
SEPTIMA: En caso de operar ajustes de incremento de la escolaridad y EL REPRESENTANTE LEGAL hubiere cancelado escolaridades por adelantado, una vez se determine la notificación de incremento, éste deberá pagar la respectiva diferencia.
OCTAVA: En caso de que EL REPRESENTANTE LEGAL se retrase en el pago de una o más escolaridades, éste se compromete a cancelar las mismas en base al monto de la escolaridad vigente para el mes en el que efectivamente se materialice el pago. La falta de pago de dos (2) o más escolaridades o cuotas por parte de EL REPRESENTANTE LEGAL, dará lugar a que EL COLEGIO, ejerza las acciones de cobro necesarias, agotando los mecanismos de mediación y en caso de ser necesario por ante las instancias judiciales respectivas. 
NOVENA: Queda sobrentendido y así declara conocerlo y aceptarlo EL REPRESENTANTE LEGAL, que para los efectos de la inscripción de su representado para el año lectivo siguiente para el cual fue efectivamente inscrito, se deberá estar solvente con todos los pagos referentes a EL COLEGIO, en el caso en que exista algún monto adeudado, no se procederá a realizar el proceso de inscripción de su representado hasta tanto demuestre estar efectivamente solvente con EL COLEGIO.
DECIMA: Para los casos de ajustes en los montos de la escolaridad, los mismos serán notificados por escrito al EL REPRESENTANTE LEGAL, de conformidad con lo establecido en la normativa legal vigente y en los acuerdos emanados del seno de las Asambleas de Padres y Representantes, con la debida anticipación, esto es, con al menos cinco (5) días de anticipación. Las partes acuerdan y aceptan que las notificaciones de carácter administrativo, académico y otras vinculadas con EL COLEGIO, serán enviadas bien a través de correo electrónico, notificaciones personales y el servicio de mensajería de texto del que dispone EL COLEGIO.
DECIMA PRIMERA: En caso de resolución anticipada del presente contrato o en el caso de que EL ESTUDIANTE sea retirado antes del mes de abril, inclusive, EL REPRESENTANTE LEGAL, estará obligado a cancelar hasta la escolaridad correspondiente a la fecha del retiro y la proporción que corresponda al mes de agosto. De retirarlo a partir del mes de mayo deberá pagar todas las escolaridades hasta agosto; y no tendrá derecho en ambos casos, al reembolso o reintegro bajo ningún concepto ni por ninguna causa de lo pagado por concepto de matrícula, escolaridad, seguro escolar, mensualidades, cuota del Consejo Educativo y u otro concepto de obligatorio pago. EL REPRESENTANTE LEGAL, libera al COLEGIO de cualquier responsabilidad legal relacionada con el retiro de EL ESTUDIANTE, ocasionada por el incumplimiento de este contrato, tanto afecte a EL ESTUDIANTE como al REPRESENTANTE LEGAL.
DECIMA SEGUNDA:  EL REPRESENTANTE LEGAL se compromete a brindarle a su representado el apoyo necesario para que logre el perfil requerido por EL COLEGIO, en dicho sentido deberá velar para que EL ESTUDIANTE asista diaria y puntualmente a clases justificando oportunamente sus inasistencias, así como garantizar el uso correcto del uniforme escolar. Así mismo, deberá asistir a todas las citaciones, reuniones y Asambleas que tanto EL COLEGIO como el Consejo Educativo efectúen a fin de que se concrete la comunicación necesaria, asertiva y oportuna para lograr el desarrollo integral del ESTUDIANTE. Tanto EL REPRESENTANTE LEGAL como EL COLEGIO,  se comprometen a cumplir con los acuerdos que se generen en dichos encuentros.
DECIMA TERCERA: De conformidad con lo establecido en la Constitución de la República Bolivariana de Venezuela, la Ley Orgánica de Educación vigente y su reglamento, la Ley sobre la Protección de Derechos de niños, niñas y adolescentes y el Acuerdo de Convivencia Escolar de EL COLEGIO, el Derecho a la Educación es un derecho inherente al proceso de formación y crecimiento de todos los niños, niñas y adolescentes, en consecuencia el REPRESENTANTE LEGAL se obliga a garantizar a EL ESTUDIANTE este derecho mediante la inscripción oportuna así como los derechos conexos a este como lo son: el sustento, la habitación, tiempo de recreación y esparcimiento, cultura, salud, atención médica y deportes. Así mismo, EL REPRESENTANTE LEGAL acepta las siguientes obligaciones:
•	Mantener una comunicación constante con los docentes, a través de las vías formales de EL COLEGIO.
•	Acompañar en casa el trabajo escolar de EL ESTUDIANTE.
•	Garantizar a EL ESTUDIANTE el apoyo de especialistas externos, en caso de que fuera necesario, para su nivelación y entregar oportunamente a los docentes los informes de los mismos.
•	Respetar las decisiones académicas propuestas por el equipo docente de EL COLEGIO, en beneficio del desarrollo integral de EL ESTUDIANTE, tales como nivelarlo académicamente, durante el periodo de tiempo que se considere necesario, a fin de garantizar la promoción del mismo con la madurez y competencias requeridas para el grado inmediato superior.
•	Atender las disposiciones que el Departamento de Orientación o los docentes realicen, en cuanto al área socioemocional de EL ESTUDIANTE, tales como evaluaciones psicológicas u otras que consideren pertinentes y entregar oportunamente los resultados de sus evaluaciones.
•	Asistir a todas las reuniones a las que fuese convocado y de manera especial a las Asambleas Ordinarias y Extraordinarias de padres, madres, representantes y responsables, como punto de encuentro y de toma de decisiones con los aspectos escolares vinculantes en la formación de EL ESTUDIANTE.
•	Cumplir con todos los acuerdos y compromisos adquiridos en las diversas Asambleas Escolares, Reuniones de Delegados y reuniones de otro tipo que guarden relación con el ámbito escolar de EL ESTUDIANTE y donde se tomen decisiones vinculantes o relacionadas con el contexto escolar.
•	Cualquiera otra obligación o responsabilidad que de conformidad con la legislación vigente sea de su cumplimiento.
DECIMA CUARTA: EL COLEGIO por su parte, se compromete con EL REPRESENTANTE LEGAL y con EL ESTUDIANTE a cumplir los preceptos contemplados en la Constitución de la República Bolivariana de Venezuela, la Ley Orgánica de Educación vigente y su reglamento, la Ley sobre la Protección de Derechos de niños, niñas y adolescentes y el Acuerdo de Convivencia Escolar del Colegio San Francisco de Asis, referentes al derecho a la educación y sus derechos conexos en tanto le sean aplicables como corresponsable en la formación de los niños, niñas y adolescentes, en este sentido asume la responsabilidad de brindarle al ESTUDIANTE, las herramientas e insumos que sean necesarios para dar cumplimiento cabal a su misión y en este contexto se obliga a:
•	Mantener informados a los padres y representantes del desempeño académico y socio-emocional del ESTUDIANTE, a través de reuniones e informes evaluativos donde se orientará al REPRESENTANTE LEGAL, acerca del manejo diario y ayuda del ESTUDIANTE; así como también a recomendar, en caso de ser necesaria una nivelación o apoyo con un especialista externo.
•	Mantener una comunicación constante entre los docentes, Coordinación y especialistas para así trabajar en equipo, en beneficio del alumno.
•	Fomentar en el salón de clases, el respeto, el trabajo cooperativo y el fortalecimiento de valores de honestidad, solidaridad y tolerancia.
•	Participar en la investigación pedagógica, en la elaboración y aplicación de proyectos educativos con el fin de conseguir los más elevados niveles de excelencia.
•	Cumplir y hacer cumplir las disposiciones contempladas en la Ley Orgánica de Educación, Ley Orgánica de Protección de Niños, niñas y adolescentes, la Constitución de la República Bolivariana de Venezuela y el Acuerdo de Convivencia Escolar.
•	Notificar al REPRESENTANTE LEGAL de manera inmediata, sobre cualquier accidente o situación de su representado que amerite su presencia en EL COLEGIO.
•	Cualquiera otra que de conformidad con la normativa legal vigente sea de su interés. 
DECIMA QUINTA: Los derechos humanos inherentes a los niños, niñas y adolescentes, consagrados en la Constitución de la República Bolivariana de Venezuela, la Ley Orgánica de Educación y su Reglamento, la Ley Orgánica para la Protección del Niño y del Adolescente, son parte inherente a este contrato y en consecuencia se dan aquí por reproducidos y reconocidos y de manera particular los previstos en los artículos:
Constitución de la República Bolivariana de Venezuela: 
Art 54.- Los padres, representantes o responsables tienen la obligación inmediata de garantizar la educación de los niños y adolescentes. 
Ley Orgánica para la Protección de Niños, niña y adolescente.
Artículo 53.- Todos los niños, niñas y adolescentes tienen derecho a la educación. Asimismo, tienen derecho a ser inscritos y recibir educación en una escuela, plantel o instituto oficial de carácter gratuito y cercano a su residencia.
Artículo 365. - La obligación de manutención comprende todo lo relativo al sustento, vestido, habitación, educación, cultura, asistencia y atención médica, medicinas, recreación y deportes, requeridos por el niño y el adolescente. 
Artículo 366.- La obligación de manutención es un efecto de la filiación legal o judicialmente establecida, que corresponde al padre y a la madre respecto a sus hijos que no hayan alcanzado la mayoridad. Esta obligación subsiste aun cuando exista privación o extinción de la patria potestad, o no se tenga la guarda del hijo, a cuyo efecto se fijará expresamente por el juez el monto que debe pagarse por tal concepto, en la oportunidad que se dicte la sentencia de privación o extinción de la patria potestad, o se dicte alguna de las medidas contempladas en el artículo 360 de esta Ley. 
Artículo 223 .- El obligado que incumpla injustificadamente con la obligación de manutención, será sancionado con multa de uno (1) a diez (10) meses de ingreso. 
DECIMA SEXTA: De conformidad con el artículo 103 de la CRBV: Toda persona tiene derecho a una educación integral, de calidad, permanente, en igualdad de condiciones y oportunidades, sin más limitaciones que las derivadas de sus aptitudes, vocación y aspiraciones. La educación es obligatoria en todos sus niveles, desde el maternal, hasta el nivel medio diversificado. La impartida por el Estado es gratuita hasta el pregrado universitario, queda expresamente establecido que EL REPRESENTANTE LEGAL por voluntad propia inscribe a EL ESTUDIANTE en EL COLEGIO , la cual como se estableció anteriormente, es una institución privada y no gratuita, por lo que se compromete a cancelar puntualmente las cuotas establecidas.
DECIMA SEPTIMA: Queda expresamente convenido que EL COLEGIO no se hace responsable de los daños sufridos por los alumnos durante su permanencia en sus instalaciones que sean ocasionados por: terremotos, explosiones, inundaciones y/ o cualquier otra circunstancia de fuerza mayor o caso fortuito. 
DECIMA OCTAVA: EL COLEGIO se obliga a mantener vigente una póliza de seguro de accidentes personales, por lo que, en caso de ocurrir algún siniestro. EL REPRESENTANTE LEGAL aceptará y estará conforme con el monto de la cobertura y condiciones de la póliza suscrita, así como la indemnización que acuerde la compañía de seguro y en consecuencia, libera de toda responsabilidad a EL COLEGIO por cualquier excedente del monto cubierto, así como de otro daño que hubiere podido sufrir, ni por lucro cesante o daños emergentes.
DECIMA NOVENA: Queda expresamente convenido, que EL COLEGIO, se reserva el derecho de admisión en sus instalaciones, de allí que EL REPRESENTANTE LEGAL no podrá enviar para retirar a EL ESTUDIANTE de EL COLEGIO, a una persona que no haya sido autorizada previamente y por escrito por EL REPRESENTANTE LEGAL. 
VIGESIMA: Queda expresamente convenido que EL COLEGIO presta servicios complementarios y/o actividades extracurriculares, por lo que en caso de ser contratados por EL REPRESENTANTE LEGAL para EL ESTUDIANTE, los mismos deberán ser pagados aparte y de forma adicional a las escolaridad establecida por EL COLEGIO.
VIGÉSIMA PRIMERA: EL REPRESENTANTE LEGAL queda enterado que las actividades tales como: educación física, recreo, culturales y demás propias del colegio se realizan también en una cancha múltiple ubicada a una quinta de por medio a las instalaciones de EL COLEGIO y por lo tanto autoriza a EL COLEGIO para trasladar a EL ESTUDIANTE a la misma. Además, autoriza a EL ESTUDIANTE a participar en las salidas para la iglesia, comparsas, paseos  y demás actividades que organice el colegio según la programación del año escolar. 
VIGÉSIMA SEGUNDA: Por medio del presente documento EL REPRESENTANTE LEGAL declara Si ____ / No ____ autoriza a EL ESTUDIANTE para que al finalizar las actividades escolares salga de LA INSTITUCION por sus propios medios. 
VIGESIMA TERCERA: EL REPRESENTANTE LEGAL, declara estar en conocimiento y aceptar que EL COLEGIO, está activo en los diferentes medios de comunicación  de Redes Sociales, en los cuales publica información referida al ámbito escolar, actividades recreativas, deportivas y culturales, en consecuencia, reconocen que EL COLEGIO, está legitimado para el uso de dichas redes, donde podrá publicar sin necesidad del consentimiento de EL REPRESENTANTE LEGAL, de EL ESTUDIANTE o de sus padres, las imágenes de acontecimientos y eventos vinculadas a la función educativa y que se utilizan con fines de difusión en la web del colegio y en las redes sociales. EL COLEGIO, se compromete a que las imágenes de niños, niñas o adolescentes que se utilicen para publicar actividades educativas, no menoscaben los derechos inherentes a los niños, niñas y adolescentes referentes al honor, reputación, propia imagen, vida privada, intimidad familiar entre otros.
VIGESIMA CUARTA: Yo $rep_Nombres[$i] / $rep_Nombres[$j], arriba identificado, firmo en señal de haber leído el presente contrato de servicio y manifiesto estar conforme en todas y cada una de sus partes. 
VIGESIMA QUINTA: Al inscribir a su representado en EL COLEGIO, asumimos juntos, que nuestro interés superior es el niño. Afrontaremos múltiples situaciones en los cuales los criterios a utilizar se basarán en los ideales, principios, normas institucionales y en el marco jurídico actual.
Ambas partes declaran expresamente formalizar la inscripción de acuerdo a la información suministrada por EL REPRESENTANTE LEGAL en la planilla de inscripción anexa al presente contrato. Se hacen dos ejemplares de un mismo tenor y a un solo efecto, en Caracas a los $hoy_dia días del mes $hoy_mes de $hoy_ano. 


                         VITA MARIA DI CAMPO                         GIAMPIERO DI CAMPO
                         Directora Académica                            Director Administrativo
",0,'J');


$pdf->SetDrawColor(0);

//$pdf->Cell(200 , $Ln2*2 , 'Firmo en señal de haber leído y estar conforme en todas y cada una de sus partes' , 0 , 1 , 'L'); 
foreach ($Padres as $Padre){
LetraTit($pdf);
$pdf->Cell(200 , $Ln2*2 , $Padre.' / Autorizado' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(70 , $Ln2+1 , 'Nombre' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'Cédula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 
$pdf->Cell(70 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1.2 , '' , $borde2 , 1 , 'L'); 
}


$pdf->Ln(20);
$pdf->Cell(200 , $Ln2*1.5 , 'AUTORIZACIÓN' , '' , 1 , 'C'); 
$pdf->MultiCell(200 , $Ln2*1.5 , 'Yo: _________________________________________ Autorizo a mi hijo(a) a retirarse del plantel por sus propios medios luego de terminar las actividades escolares. ' , 0 , 'J'); 
$pdf->Cell(70 , $Ln2+1 , 'Fecha' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'Cédula de Ident. No.' , $borde1 , 0 , 'L'); 
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
$pdf->Cell(18 , $Ln2*1.5 , 'Depósito' , 0 , 0 , 'R'); 
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
$pdf->Cell(50 , $Ln2*2 , 'Núm:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Monto:' , 1 , 0 , 'L'); 
$pdf->Ln($Ln2*2);
$pdf->Cell(100 , $Ln2*2 , 'Recibido por: nombre:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Firma:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Fecha:' , 1 , 0 , 'L'); 
//$pdf->Ln($Ln2*2+3);
/*
LetraPeq($pdf);
$pdf->Cell(60 , $Ln2 , '¿Recibe las circulares via email? ' , 0 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'si' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'no' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , '  E-mail: _____________________________________ ' , 0 , 0 , 'L'); 
*/

?>