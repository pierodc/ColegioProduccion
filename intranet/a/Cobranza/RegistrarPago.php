<form action="<?php echo $editFormAction; ?>#Pendiente" method="post" name="form1" id="form1">
         <table class="sombra" >
          <caption>Registrar Pago</caption>
               <tr valign="baseline">
              <td width="10%" align="right" nowrap="nowrap" class="NombreCampo">
Fecha</td>
              <td width="40%" align="left" nowrap="nowrap" class="FondoCampo"><input name="Fecha" type="date" id="Fecha" value="<?php echo date('Y-m-d') ?>" />
              </td>
              <td width="10%" align="right" class="NombreCampo">Cash $</td>
              <td width="25%" class="FondoCampo"><input type="text" name="MontoHaber_Dolares" value="" size="15"  />
              <input type="hidden" name="Cambio_Dolar" value="<? echo $Cambio_Dolar_Hoy ?>" size="15"  /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">&nbsp;</td>
              <td width="40%" align="left" nowrap="nowrap" class="FondoCampo">
              	
              	<? $Banco->Select_movimientos ($tipo = "ZLL"); ?>
              	
              </td>
              <td width="10%" align="right" class="NombreCampo">Zelle $</td>
              <td width="40%" class="FondoCampo"><input type="text" name="MontoHaber_Dolares_Zelle" value="" size="15"  /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Forma de Pago</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><label>
                <select name="Tipo" id="Tipo" required>
                  <option>Seleccione...</option>
                  <option value="4">Efectivo</option>
                  <option value="3">Cheque</option>
                  <option value="1">Deposito</option>
                  <option value="2" <? echo $UltimoTipo==2?" selected":""; ?>>Transferencia</option>
                  <option value="6">T. Debito</option>
                  <option value="7">T. Credito</option>
                  <option value="">---</option>
                  <option value="8">Zelle</option>
                  <option value="9">Cash Dollares</option>
                  <option value="10">Cash Euro</option>
                  <option value="">---</option>
                  <option value="5">Ajuste</option>
                </select>
              </label>
              <span onClick="document.form1.Tipo.selectedIndex=4;document.form1.CodigoCuenta.selectedIndex=2;document.form1.Referencia.focus()"> Transf </span> | <span onClick="document.form1.Tipo.selectedIndex=5;document.form1.CodigoCuenta.selectedIndex=3"> Debito </span> | <span onClick="document.form1.Tipo.selectedIndex=6;document.form1.CodigoCuenta.selectedIndex=3"> Credito </span></td>
              <td align="right" class="NombreCampo">Bs</td>
              <td class="FondoCampo"><input type="text" name="MontoHaber" value="" size="15"  onFocus="this.value=<?php echo $UltimoMonto; ?>"   /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Pagado en</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><label>
                <select name="CodigoCuenta" id="CodigoCuenta" required>
                  <option value="10" <? echo $UltimoBanco==""?" selected":""; ?>>Caja</option>
                  <option value="1" <? echo $UltimoBanco==1?" selected":""; ?>>Mercantil</option>
                  <option value="2" <? echo $UltimoBanco==2?" selected":""; ?>>Provincial</option>
                  <option value="5">Activo</option>
                  <option value="">---</option>
                  <option value="6">Zelle</option>
                  <option value="7">Cash Dollares</option>
                  <option value="8">Cash Euro</option>
                </select>
              </label>
              <span onClick="document.form1.CodigoCuenta.selectedIndex=1"> Mercantil </span> | <span onClick="document.form1.CodigoCuenta.selectedIndex=2"> Provincial </span> | <span onClick="document.form1.CodigoCuenta.selectedIndex=3"> Activo </span></td>
              <td class="NombreCampo">&nbsp;</td>
              <td class="FondoCampo">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Referencia</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="Referencia" value="" size="15" onFocus="this.value=<?php echo $_SESSION['Referencia'] ?>" /> 
                Banco Origen 
                <input name="ReferenciaBanco" type="text" id="ReferenciaBanco" size="15" /></td>
              <td class="NombreCampo">&nbsp;</td>
              <td class="FondoCampo">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Observaciones</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><input name="Observaciones" type="text" id="Observaciones" size="50" /></td>
              <td class="NombreCampo">&nbsp;</td>
          <td class="FondoCampo">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap" class="NombreCampo">Facturar a:</td>
              <td align="left" nowrap="nowrap" class="FondoCampo"><select name="CodigoReciboCliente" id="select">
                <?php 
				$sql = "SELECT * FROM ReciboCliente
						WHERE CodigoAlumno = '$CodigoAlumno'";
				$RS = $mysqli->query($sql);
				$row = $RS->fetch_assoc();
				$totalRows = $RS->num_rows;
				if($totalRows >= 1){
				?>
                <option value="0">Seleccione...</option>
                <?php }
				do{
					extract($row);
					echo "<option value=\"$Codigo\">$Nombre</option>";
				} while($row = $RS->fetch_assoc());
				
				  ?>
              </select>
(<a href="Recibo_Crea_Cliente.php?CodigoAlumno=<?php echo $CodigoAlumno ?>&amp;CodigoPropietario=<?php echo $_GET['CodigoPropietario'] ?>">crea Nombre</a>)
<input type="hidden" name="CodigoPropietario" value="<?php echo $CodigoAlumno; ?>" />
<input type="hidden" name="RegistradoPor" value="<?php echo $MM_Username; ?>" />
<input type="hidden" name="Descripcion" value="Abono a cuenta" />
<input type="hidden" name="MontoDebe" value="" />
<input type="hidden" name="FechaIngreso" value="<?php echo date('Y-m-d h:i:s'); ?>" />
<input type="hidden" name="MM_insert" value="form1" />
<input name="MontoDocOriginal" type="hidden" id="MontoDocOriginal" size="15" /></td>
              <td class="NombreCampo">&nbsp;</td>
              <td class="FondoCampo"><input type="submit" value="Guardar"  onClick="this.disabled=true;this.form.submit();" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap">                    </td>
              </tr>
          </table>
          </form>