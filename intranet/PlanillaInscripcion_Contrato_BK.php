<?php 


$pdf->AddPage();
LetraGdeBlk($pdf);
$pdf->Cell(200 , $Ln1 , 'U.E. Colegio San Francisco de As�s' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'INSCRITO EN EL MPPE C�DIGO S0934D1507' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Los Palos Grandes, Municipio Chacao del Estado Miranda' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Contrato de Prestaci�n de Servicios Educativos ' , 0 , 1 , 'C'); 

$pdf->SetFont('Arial','',9);
$i=1;$j=2;
$Fecha_Nac = substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ;

$pdf->MultiCell(200, 3.2 ,"Entre ________________________, venezolano, mayor de edad, de este domicilio, identificado con la c�dula de identidad No. V-________________, en su car�cter de representante de la Unidad Educativa COLEGIO SAN FRANCISCO DE AS�S, inscrito ante el Ministerio de Educaci�n y Deportes bajo el No. S0934D1507, ubicado en la calle 7 entre 4ta. Y 5ta. Av. de la Urbanizaci�n Los Palos Grandes, Caracas, en lo adelante y a los efectos de este contrato LA INSTITUCI�N, por una parte; y, por la otra, $rep_Nombres[$i] / $rep_Nombres[$j], de nacionalidad $rep_Nacionalidad[$i] / $rep_Nacionalidad[$j], mayor de edad, de este domicilio, identificado con la c�dula de identidad No. $rep_Cedula[$i]/$rep_Cedula[$j], en lo adelante EL REPRESENTANTE LEGAL, actuando en su car�cter de ________/________ del menor $Apellidos $Nombres, de nacionalidad $Nacionalidad, nacido en  $Localidad, el d�a $Fecha_Nac, en lo adelante EL ESTUDIANTE, se ha convenido en celebrar como en efecto se celebra el presente CONTRATO DE PRESTACI�N DE SERVICIOS EDUCATIVOS, el cual se regir� por las siguientes cl�usulas:
    Cl�usula Primera : LA INSTITUCION es una empresa de car�cter privado no subsidiada por un ente oficial, ni de la administraci�n p�blica central ni descentralizada, que presta servicios de instrucci�n, atenci�n, educaci�n y cuidado en general a estudiantes que as� lo soliciten, prestando sus servicios durante los d�as h�biles en el calendario educativo que a tal efecto decrete el Ministerio del P.P. para la Educaci�n, en el turno indicado y en las condiciones del presente contrato. En virtud a lo anterior, LA INSTITUCION se compromete a brindar a EL ESTUDIANTE una educaci�n de calidad, garantizar el adecuado mantenimiento de su planta f�sica, garantizar la dotaci�n de los insumos necesarios para su buen funcionamiento, as� como garantizar la contrataci�n de personal capacitado, poseedor de valores �ticos y morales. 
    Cl�usula Segunda : Forman parte integrante del presente contrato las estipulaciones contenidas en el mismo, el Manual de Convivencia Escolar de LA INSTITUCION, el cual se encuentra publicado en la p�gina web www.sanfrancisco.e12.ve, el cual declaran conocer y aceptar y, las declaraciones e informaciones contenidas en las solicitudes firmadas por EL REPRESENTANTE LEGAL de EL ESTUDIANTE y los anexos incorporados en el expediente correspondiente; todo lo cual EL REPRESENTANTE LEGAL declara expresamente conocer y estar conforme con los mismos. 
    Cl�usula Tercera: La vigencia del presente contrato es por el t�rmino de un a�o fijo escolar, entendiendo por tal el que se inicia el 16 de septiembre de $Ano1prox y culmina el 31 de julio de $Ano2prox. 
    Cl�usula Cuarta: El presente contrato se perfecciona una vez que EL REPRESENTANTE LEGAL suscriba el registro de EL ESTUDIANTE y cancele total o parcialmente el monto correspondiente de la matr�cula o inscripci�n, �tiles escolares o materiales, Seguro Escolar, Servicio de Ambulancia, cuota anual de la Comit� de Padres y Representantes, actividades extracurriculares y mensualidades. 
    Cl�usula Quinta: Se entiende como \"Actividades Extracurriculares\", optativas, aquellas que est�n fuera del pensum de estudio exigido por el Ministerio del Poder Popular para la Educaci�n. Asimismo, comprende las horas de clases impartidas en las distintas materias, adicionales a las exigidas por el mismo Ministerio. En Educaci�n Inicial, Educaci�n Primaria, Educaci�n Media General comprende las clases de Ingl�s, Italiano y Computaci�n. En Educaci�n Media General comprende horas adicionales de matem�ticas, castellano, sociales, curso de cultura e idioma italiano, ingl�s impartido a trav�s de academias especializadas con grupos de reducidos n�mero de alumnos, Horas de orientaci�n. Adem�s incluye en todos los niveles las conmemoraciones y participaci�n en distintas actividades que forman parte de la idiosincracia de LA INSTITUCI�N. Estas Actividades Extracurriculares son optativas.
    Cl�usula Sexta: LA INSTITUCION se compromete a prestar sus servicios a EL ESTUDIANTE, empleando para ello todos sus conocimientos y dedicaci�n para el mayor �xito de las funciones que le son encomendadas; y, por su parte, EL REPRESENTANTE LEGAL se obliga a cumplir y hacer cumplir a EL ESTUDIANTE, todas y cada una de las estipulaciones del presente contrato, as� como El Manual de Convivencia Escolar de LA INSTITUCI�N. Asimismo, EL REPRESENTANTE LEGAL como contraprestaci�n al servicio que se obliga impartir LA INSTITUCI�N, pagar� a �sta los derechos de matr�cula, escolaridad y actividades extracurriculares correspondientes al a�o escolar anteriormente definido, que incluyen el pago de doce (12) cuotas mensuales y consecutivas, las cuales deber�n ser canceladas durante los primeros cinco (5) d�as de cada mes. El retraso en el pago puede generar intereses de mora. 
	Cl�usula S�ptima: EL REPRESENTANTE LEGAL y LA INSTITUCION est�n obligados a cumplir y hacer cumplir lo que establece la normativa legal vigente en cuanto a establecer las acciones necesarias para mantener el equilibrio esperado en la salud f�sica y mental de EL ESTUDIANTE. Asimismo, EL REPRESENTANTE LEGAL  deber� asistir a todas las citaciones y reuniones que LA INSTITUCI�N establezca a fin de que se logre la comunicaci�n necesaria, asertiva y oportuna para lograr el desarrollo integral de EL ESTUDIANTE. En estas reuniones y/o citaciones tanto EL REPRESENTANTE LEGAL  como  LA INSTITUCION deber�n cumplir con los acuerdos que se generen en ellas y en oportunidades, cuando la situaci�n lo amerite, EL ESTUDIANTE ser� parte importante en el cumplimiento de lo acordado, por lo que el mismo deber� ser incluido en dichas acciones acad�mico-administrativas.
    Cl�usula Octava: EL REPRESENTANTE LEGAL declara expresamente aceptar los montos fijados como derechos de escolaridad para el a�o escolar, los cuales podr�n ser objeto de ajustes por variaci�n de los costos, tales como incremento en la remuneraci�n del personal, aumentos de los servicios p�blicos, bonos, cualquier otro tipo de beneficio, aumentos de equipos, insumos, y/ o acuerdos de Contrataci�n Magisterial, siempre y cuando sean permitidos legalmente. Queda entendido que en caso de ajustes de los derechos de la escolaridad, LA INSTITUCION deber� notificar por escrito a EL REPRESENTANTE LEGAL con por lo menos treinta (30) d�as de anticipaci�n, la cual se har� mediante circular enviada a trav�s de EL ESTUDIANTE. En caso de operar aumentos y EL REPRESENTANTE LEGAL hubiere cancelado mensualidades por adelantado o aquellas correspondientes al per�odo vacacional, una vez se practique la debida notificaci�n se deber� pagar la diferencia respectiva. 
    Cl�usula Novena: La falta de pago de una o m�s mensualidades o cuotas por parte de EL REPRESENTANTE LEGAL, se considerar� como imposibilidad en sustentar la educaci�n privada de su representado o EL ESTUDIANTE, por lo que LA INSTITUCION coadyuvar� en la b�squeda y consecuci�n de un cupo en una instituci�n de car�cter p�blico para �ste. 
    Cl�usula D�cima: En caso de resoluci�n anticipada del presente contrato o en el caso de que EL ESTUDIANTE sea retirado, EL REPRESENTANTE LEGAL estar� obligado a cancelar hasta la mensualidad correspondiente a la fecha del retiro , y no tendr� derecho al reembolso o reintegro bajo ning�n concepto ni por ninguna causa de lo pagado por concepto de matr�cula, escolaridad, renovaci�n de inscripci�n, seguro escolar, mensualidades y material. EL REPRESENTANTE LEGAL libera a LA INSTITUCI�N de cualquier responsabilidad legal relacionada con el retiro de EL ESTUDIANTE, motivado por el incumplimiento de este contrato tanto de EL REPRESENTANTE LEGAL como de EL ESTUDIANTE. 
    Cl�usula D�cimoprimera: EL REPRESENTANTE LEGAL podr� reservar la inscripci�n de EL ESTUDIANTE antes de la finalizaci�n del a�o escolar, llenando a tal efecto la planilla correspondiente y cancelando una parte de la misma. El pago que resultare pendiente ser� cancelado por EL REPRESENTANTE LEGAL en el transcurso del mes de julio. En caso que quedare pendiente parte del pago del a�o escolar inmediato anterior, la misma deber� ser pagada antes del primero (1ero) de septiembre del nuevo a�o escolar. 
    Cl�usula D�cimosegunda: La Ley Org�nica para la Protecci�n del Ni�o y del Adolescente establece: 
    Art�culo 54.- Los padres, representantes o responsables tienen la obligaci�n inmediata de garantizar la educaci�n de los ni�os y adolescentes . 
    Art�culo 53 .- Todos los ni�os y adolescentes tienen derecho a la educaci�n. Asimismo, tienen derecho a ser inscritos y recibir educaci�n en una escuela, plantel o instituto oficial de car�cter gratuito y cercano a su residencia. 
    Art�culo 365. - La obligaci�n alimentaria comprende todo lo relativo al sustento, vestido, habitaci�n, educaci�n, cultura, asistencia y atenci�n m�dica, medicinas, recreaci�n y deportes, requeridos por el ni�o y el adolescente. 
    Art�culo 366 .- La obligaci�n alimentaria es un efecto de la filiaci�n legal o judicialmente establecida, que corresponde al padre y a la madre respecto a sus hijos que no hayan alcanzado la mayoridad. Esta obligaci�n subsiste aun cuando exista privaci�n o extinci�n de la patria potestad, o no se tenga la guarda del hijo, a cuyo efecto se fijar� expresamente por el juez el monto que debe pagarse por tal concepto, en la oportunidad que se dicte la sentencia de privaci�n o extinci�n de la patria potestad, o se dicte alguna de las medidas contempladas en el art�culo 360 de esta Ley. 
    Art�culo 223 .- El obligado alimentario que incumpla injustificadamente, ser� sancionado con multa de uno (1) a diez (10) meses de ingreso. 
    Por su parte, la Constituci�n de la Rep�blica Bolivariana de Venezuela, en su art�culo 103 consagra: Toda persona tiene derecho a una educaci�n integral, de calidad, permanente, en igualdad de condiciones y oportunidades, sin m�s limitaciones que las derivadas de sus aptitudes, vocaci�n y aspiraciones. La educaci�n es obligatoria en todos sus niveles, desde el maternal, hasta el nivel medio diversificado. La impartida por el Estado es gratuita hasta el pregrado universitario. 
    En virtud a lo antes expuesto, queda expresamente establecido que EL REPRESENTANTE LEGAL por voluntad propia inscribe a EL ESTUDIANTE en LA INSTITUCI�N , la cual como se estableci� anteriormente, es una instituci�n privada y no gratuita, por lo que se compromete a cancelar puntualmente las cuotas establecidas. Todo retraso en los pagos genera intereses de mora a raz�n de 1% mensual.
    Cl�usula D�cimotercera: Queda expresamente convenido que LA INSTITUCION no es responsable por da�os sufridos por los alumnos durante su permanencia en sus instalaciones, ocasionados por terremotos, explosiones, inundaciones y/ o cualquier otra circunstancia de fuerza mayor o caso fortuito. 
    Cl�usula D�cimocuarta: LA INSTITUCION se obliga a mantener vigente una p�liza de seguro de accidentes personales, por lo que, en caso de ocurrir alg�n siniestro , EL REPRESENTANTE LEGAL aceptar� y estar� conforme con el monto de la cobertura y condiciones de la p�liza suscrita, as� como la indemnizaci�n que acuerde la compa��a de seguro y en consecuencia, libera de toda responsabilidad a LA INSTITUCION por cualquier excedente del monto cubierto, as� como de otro da�o que hubiere podido sufrir, ni por lucro cesante o da�os emergentes. 
    Cl�usula D�cimoquinta: Si en el momento de la inscripci�n EL REPRESENTANTE LEGAL no solicit� la inscripci�n en cualquiera de las asignaciones o servicios prestados en el colegio, �sta no podr� realizarla hasta despu�s de iniciarse el mes de enero del a�o escolar en curso. 
    Cl�usula D�cimosexta: Queda expresamente convenido que en caso de que EL ESTUDIANTE llegare a contraer una enfermedad contagiosa, EL REPRESENTANTE LEGAL deber� abstenerse de enviarlo a LA INSTITUCI�N, debiendo en todo caso, enviar una comunicaci�n escrita con la constancia m�dica correspondiente. 
    Cl�usula D�cimos�ptima: Toda solicitud de constancia de estudios y/o alg�n otro documento, de ser procedente, ser� tramitada en un lapso m�nimo de tres (3) d�as h�biles contados a partir de la fecha efectiva de su solicitud. 
    Cl�usula D�cimoctava: EL REPRESENTANTE LEGAL no podr� enviar para retirar de LA INSTITUCI�N a EL ESTUDIANTE, a una persona que no haya sido autorizada previamente por EL REPRESENTANTE LEGAL por escrito. 
    Cl�usula D�cimonovena: En caso de ocurrir hechos que menoscaben la integridad material de LA INSTITUCI�N, EL REPRESENTANTE LEGAL se compromete a cubrir los gastos de reposici�n de aquellos bienes que hayan sufrido da�os, causados por EL ESTUDIANTE. 
    Cl�usula Vig�sima: Queda expresamente convenido que LA INSTITUCI�N presta como servicios complementarios y/o actividades extracurriculares, servicio de comedor, clases de danza, computaci�n, k�rate, futbolito, pintura, ajedrez, por lo que en caso de ser contratados por EL REPRESENTANTE LEGAL para EL ESTUDIANTE, los mismos deber�n ser cancelados aparte y de forma adicional a las mensualidades. 
    Cl�usula Vig�simaprimera: Queda expresamente convenido que LA INSTITUCI�N no presta servicio de transporte escolar, por lo que no se hace responsable por la forma en que EL ESTUDIANTE llega y/o se retira de LA INSTITUCI�N. 
    Cl�usula Vig�simasegunda: EL REPRESENTANTE LEGAL  queda enterado que las actividades tales como: educaci�n f�sica, recreo, culturales y dem�s propias del colegio se realizan tambi�n en una cancha m�ltiple ubicada a una quinta de por medio a las instalaciones del colegio y por lo tanto autoriza al colegio para trasladar a su representado a la misma. Adem�s, autoriza a su representado a participar en las salidas para la iglesia de Santa Eduvigis, comparsas y dem�s actividades que organice el colegio seg�n la programaci�n del a�o escolar.
	Cl�usula Vig�simatercera:  Por medio del presente documento EL REPRESENTANTE LEGAL declara Si ____ / No ____ autorizar a EL ESTUDIANTE para que al finalizar las actividades escolares salga de LA INSTITUCION por sus propios medios. 
    Ambas partes  declaran expresamente formalizar la inscripci�n de acuerdo a la informaci�n suministrada por el representante en la planilla de inscripci�n anexa al presente contrato.
    Se hacen dos ejemplares de un mismo tenor y a un solo efecto, en Caracas a los $hoy_dia d�as del mes $hoy_mes de $hoy_ano. ",0,'J');


$pdf->SetDrawColor(0);

$pdf->Cell(200 , $Ln2*2 , 'Firmo en se�al de haber le�do y estar conforme en todas y cada una de sus partes' , 0 , 1 , 'L'); 
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


$pdf->Ln(1);
$pdf->Cell(200 , $Ln2*1.5 , 'AUTORIZACI�N' , '' , 1 , 'C'); 
$pdf->MultiCell(200 , $Ln2*1.5 , 'Yo: _________________________________________ Autorizo a mi hijo(a) a retirarse del plantel por sus propios medios luego de terminar las actividades escolares. ' , 0 , 'J'); 
$pdf->Cell(70 , $Ln2+1 , 'Fecha' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'C�dula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 

$pdf->Cell(70 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1 , '' , $borde2 , 1 , 'L'); 

/*
$pdf->SetFont('Arial','B',10);
$pdf->Ln(1);
$pdf->Cell(200 , $Ln2 , '' , 'T' , 1 , 'C'); 
$pdf->Cell(80 , $Ln2*1.3 , 'Actividades en la tarde:' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(20 , $Ln2*1.5 , 'Comedor' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Tareas' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Futbol' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Danza' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Compu' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Pint' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Otra' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln2*1.5 , '_______________' , 0 , 0 , 'L');
*/

$pdf->SetFont('Arial','B',10);
$pdf->Ln(1);
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