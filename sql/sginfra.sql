  Dlg_SolTrans: TDlg_SolTrans;

  VfStrATFunc  : String;
  VfStrSQl     : String;  // Sql
  VfSql        : String;
  VfStrValDta  : String;
  VfBitGrava   : Boolean; // Alterar
  VfBitTipo    : Boolean; // Alterar
  VfIntFun     : Integer; // Código do Funcionário
  VfIntSetor   : Integer; // Código do Setor Solicitante
  VfIntCodStat : Integer; // Código do STatus
  VfIntCodInst : Integer; // Código da Instituição
  VfScreenMode : Integer;
  VfIntIdx     : Integer; // IDX

implementation

uses Global, Principal, BuscaCadastro, BuscaManu, BuscaTransp,
     Fornecedor, MultiEdit, Setor, Ficha_SolTransporte;

{$R *.dfm}

procedure TDlg_SolTrans.FormShow(Sender: TObject);
begin
    VfScreenMode := VgIntScreenMode;
    Edit_Out;
    Editar.ShortCut := 0;               VfIntIdx := 0;

    CASE VfScreenMode OF
       701:Begin // Adm
              VfStrATFunc := Dlg_Principal.QueryAcc.FieldByName('ATSTA').AsString;
              TS_ASS.TabVisible := False;
              VfBitTipo := True;
           End;
       702:Begin // ASS
              VfStrATFunc := Dlg_Principal.QueryAcc.FieldByName('ATSTP').AsString;
              Imprimir.Visible := True;     Imprimir.Enabled := False;
              TS_ADM.TabVisible := False;
              VfBitTipo := False;
           End;
       703:Begin // Adm e ASS
              VfStrATFunc := Dlg_Principal.QueryAcc.FieldByName('ATTMap').AsString;
              VfBitTipo := False;
           End;
    END; // CASE
    // Altera Registros
    NovoReg.Visible := True;      NovoReg.Enabled := True;
    Gravar.Visible := True;       Gravar.Enabled := False;

    IF (VfStrATFunc = 'A')OR(VfStrATFunc = 'I')OR(VfStrATFunc = 'E') Then Begin
       Imprimir.Visible := True;     Imprimir.Enabled := False;
    End;

    // Inclui Registros
    IF (VfStrATFunc = 'I') OR (VfStrATFunc = 'E') Then Begin
       Editar.Visible := True;       Editar.Enabled := False;
       Editar.ShortCut :=  114;
    End;

    PgControl.TabIndex := 0;
    FirstReg.Enabled := False;       PrevReg.Enabled := False;
    LastReg.Enabled := False;        NextReg.Enabled := False;

  // Todas as Abas
    IF Dlg_Principal.QueryAcc.FieldByName('AZ_ST').AsBoolean = True Then Begin
       BtnAp.Visible := True;        BtnAp.Enabled := False;
       BtnCanc.Visible := True;      BtnCanc.Enabled := False;
    END;

  //// Impressão ////
    CASE DayOfWeek(Date()) OF
       1,7:Imprimir.Visible := True;
       2,3,4,5,6:IF (HourOfTheDay(NOW) < 8) OR (HourOfTheDay(NOW) > 17) THEN
              Imprimir.Visible := True;
    End;
    IF Dlg_Principal.QueryAcc.FieldByName('BT_TransRc').AsBoolean = True Then
       Imprimir.Visible := True;

   /// Modo Consulta
   IF VgStrSql_In = '' THEN Exit;
   VfStrSql := 'WHERE ' + VgStrSql_In;
   Open_Dados;
   Carrega_dados;
end;

////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Carrega Dados ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.Open_Dados;
Begin
    FirstReg.Enabled := False;  PrevReg.Enabled := False;;
    QueryL.Close;
    QueryL.SQL.Clear;
    QueryL.SQL.Add('SELECT Tb_TranSol.TrSol_Idx, Tb_TranSol.TrSol_NSer, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_CodSet, Tb_TranSol.TrSol_Status, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_CodStat, Tb_TranSol.TrSol_Idade, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_NPess, Tb_TranSol.TrSol_Paciente, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_Leito, Tb_TranSol.TrSol_Quarto, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_Destino, Tb_TranSol.TrSol_Patologia, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_HRet, Tb_TranSol.TrSol_HoraAg, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_AmbJust, Tb_TranSol.TrSol_Just, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_Obs, Tb_TranSol.TrSol_BitRet, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_BitAmbS, Tb_TranSol.TrSol_BitAmbU, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_BitAmbN, Tb_TranSol.TrSol_BitAcom, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_Tipo, Tb_TranSol.TrSol_DtaAg, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_DataC, Tb_TranSol.TrSol_UsuC, ');
    QueryL.SQL.Add('Tb_TranSol.TrSol_CodInst, ');
    QueryL.SQL.Add('tb_Func.Func_Nome, Tb_Jurinst.JurI_Nome, ');
    QueryL.SQL.Add('tb_Setor.Setor_Setor, tb_Setor.Setor_Ccusto ');
    QueryL.SQL.Add('FROM Sginfra.Tb_TranSol ');
    QueryL.SQL.Add('LEFT JOIN Sginfra.Tb_Func ON Tb_TranSol.TrSol_UsuC = tb_Func.Func_Idx ');
    QueryL.SQL.Add('LEFT JOIN Sginfra.Tb_Setor ON Tb_TranSol.TrSol_CodSet = tb_Setor.Setor_Idx');
    QueryL.SQL.Add('LEFT JOIN Sginfra.Tb_Jurinst ON tb_TranSol.trsol_codinst = Tb_Jurinst.JurI_Idx ');
    QueryL.SQL.Add(VfStrSql+ ';');
    QueryL.Open;
End;

procedure TDlg_SolTrans.Open_Sigh;
Begin
    Edit_SPP.Text := Dlg_Principal.Valida_Numero(Edit_SPP.Text,0);
    IF Edit_SPP.Text = '0' THEN Exit;
    ZQuerySigh.Close;
    ZQuerySigh.SQL.Clear;
    ZQuerySigh.SQL.Add('SELECT pacientes.nm_paciente, pacientes.spp, ');
    ZQuerySigh.SQL.Add('pacientes.data_nasc, ficha_amb_int.data_atendimento, ');
    ZQuerySigh.SQL.Add('leitos.nm_leito, quartos_enfermarias.nm_quarto ');
    ZQuerySigh.SQL.Add('FROM sigh.pacientes ');
    ZQuerySigh.SQL.Add('LEFT JOIN sigh.ficha_amb_int ON sigh.pacientes.id_paciente = ficha_amb_int.cod_paciente ');
    ZQuerySigh.SQL.Add('LEFT JOIN sigh.leitos ON ficha_amb_int.cod_leito = leitos.id_leito ');
    ZQuerySigh.SQL.Add('LEFT JOIN sigh.quartos_enfermarias ON sigh.leitos.cod_quarto_enf  = quartos_enfermarias.id_quarto_enf ');
    ZQuerySigh.SQL.Add('WHERE (pacientes.ativo is true) ');
    ZQuerySigh.SQL.Add('AND (tipo_atend IN('+chr(39)+'AMB'+chr(39)+','+chr(39)+'INT'+chr(39)+')) ');
    ZQuerySigh.SQL.Add('AND (pacientes.spp = '+ Edit_SPP.Text +')');
    ZQuerySigh.SQL.Add('ORDER BY data_atendimento DESC;');
    ZQuerySigh.Open;
    IF ZQuerySigh.RecordCount < 1 THEN Begin
       MessageDlg('SPP Inexistente!',  mtWarning, [mbOK], 0);  Exit;
    End;
    Edit_NomePas.Text := ZQuerySigh.FieldByName('nm_paciente').AsString;
    Edit_IDP.Text := IntToStr(YearsBetween(DATE(), ZQuerySigh.FieldByName('data_nasc').AsDateTime));
    Edit_Quarto.Text := ZQuerySigh.FieldByName('nm_quarto').AsString;
    Edit_Leito.Text := ZQuerySigh.FieldByName('nm_leito').AsString;
End;


procedure TDlg_SolTrans.Carrega_Dados;
Begin
    IF (QueryL.RecordCount = 0) Then Begin Limpa_Tela; Exit; End;
    IF (QueryL.RecordCount > 1) Then Begin
        NextReg.Enabled := True;  LastReg.Enabled := True;
    End;

    /////// Cabeçalho
    Edit_Code.Text := QueryL.FieldByName('TrSol_NSer').AsString;  // Código da SS

    ///////// Status: 0.Aberta, 1.Aprovada, 2.Agendada, 3.Concluida, 4.Cancelada
    VfIntCodStat := QueryL.FieldByName('TrSol_CodStat').AsInteger; // Código da SS
    VfIntSetor   := QueryL.FieldByName('TrSol_CodSet').ASInteger;  // Código do Setor Solicitante
    VfIntCodInst := QueryL.FieldByName('TrSol_CodInst').ASInteger;  // Código da Instituição
    VfIntFun     := QueryL.FieldByName('TrSol_UsuC').AsInteger;
    VfIntIdx     := QueryL.FieldByName('TrSol_Idx').AsInteger;  // Código Idx
    IF VfScreenMode = 703 THEN
       VfBitTipo := QueryL.FieldByName('TrSol_Tipo').AsBoolean;

    CASE VfIntCodStat OF
       0:Begin
            Editar.Enabled := True;           Imprimir.Enabled := True;
            BtnAp.Enabled := True;            BtnCanc.Enabled := True;
         End;
       1,2:Begin
            Editar.Enabled := False;          Imprimir.Enabled := True;
            BtnAp.Enabled := False;            BtnCanc.Enabled := True;
         End;
       3,4:Begin
            Editar.Enabled := False;          Imprimir.Enabled := False;
            BtnAp.Enabled := False;           BtnCanc.Enabled := False;
         End;
    End; // Case

    IF VfBitTipo = True THEN Begin
       TS_ASS.TabVisible := False;     TS_ADM.TabVisible := True;
       /////// Pagina 1
       Edit_Inst.Text   := QueryL.FieldByName('JurI_Nome').AsString;// Instituição
       Edit_CodSol.Text := QueryL.FieldByName('TrSol_Idx').AsString;// Código do Status da SS
       Edit_DtaAb.Text  := QueryL.FieldByName('TrSol_DataC').AsString; // Data Abertura
       Edit_Status.Text := QueryL.FieldByName('TrSol_Status').AsString;  // Status da SS
       Edit_Func.Text   := QueryL.FieldByName('Func_Nome').AsString; // Nome do Funcionário
       Edit_SetSol.Text := QueryL.FieldByName('Setor_Ccusto').AsString + ' - '+
                            QueryL.FieldByName('Setor_Setor').AsString;    // Setor Solicitante
       Edit_NFunc.Text  := QueryL.FieldByName('TrSol_NPess').AsString; // Patrimônio
       Edit_DtaTrans.Text := QueryL.FieldByName('TrSol_DtaAg').AsString; // Prazo de Entrega
       Edit_HIda.Text     := QueryL.FieldByName('TrSol_HoraAg').AsString; // TAG da Aplicação
       Edit_Local.Text    := QueryL.FieldByName('TrSol_Destino').AsString;// Data do Encerramento
       CBox_Retorno.Checked  := QueryL.FieldByName('TrSol_BitRet').AsBoolean;
       Edit_HRetorno.Enabled :=  CBox_Retorno.Checked;
       Edit_HRetorno.Text    := QueryL.FieldByName('TrSol_HRet').AsString;  // Data da Abertura
       Memo_Sol.Lines.Text   := QueryL.FieldByName('TrSol_Just').AsString;
       Memo_Obs.Lines.Text   := QueryL.FieldByName('TrSol_Obs').AsString; // Descrição da Solicitação
    End
    ELSE Begin
      TS_ASS.TabVisible := True;      TS_ADM.TabVisible := False;
      //////// Pagina 2
      Edit_CodSol1.Text := QueryL.FieldByName('TrSol_Idx').AsString;// Código do Status da SS
      Edit_DtaAb1.Text  := QueryL.FieldByName('TrSol_DataC').AsString; // Data Abertura
      Edit_Func1.Text   := QueryL.FieldByName('Func_Nome').AsString;   // Nome do Funcionário
      Edit_Inst1.Text   := QueryL.FieldByName('JurI_Nome').AsString;   // Instituição
      Edit_Status.Text  := QueryL.FieldByName('TrSol_Status').AsString;// Status da SS
      Edit_SetSol1.Text := QueryL.FieldByName('Setor_Ccusto').AsString + ' - ' +
                           QueryL.FieldByName('Setor_Setor').AsString;// Setor Solicitante
      Edit_NomePas.Text := QueryL.FieldByName('TrSol_Paciente').AsString;  // Paciente
      Edit_Quarto.Text  := QueryL.FieldByName('TrSol_Quarto').AsString;
      Edit_Leito.Text   := QueryL.FieldByName('TrSol_Leito').AsString;  // Paciente
      Edit_IDP.Text     := QueryL.FieldByName('TrSol_Idade').AsString;
      Edit_Patologia.Text := QueryL.FieldByName('TrSol_Patologia').AsString;
      CBox_Acomp.Checked  := QueryL.FieldByName('TrSol_BitAcom').AsBoolean;
      Edit_DtaTrans1.Text := QueryL.FieldByName('TrSol_DtaAg').AsString; // Prazo de Entrega
      Edit_HIda1.Text     := QueryL.FieldByName('TrSol_HoraAg').AsString; // TAG da Aplicação
      Edit_Local1.Text    := QueryL.FieldByName('TrSol_Destino').AsString;// Data do Encerramento
      CBox_Retorno1.Checked  := QueryL.FieldByName('TrSol_BitRet').AsBoolean;
      Edit_HRetorno1.Enabled :=  CBox_Retorno.Checked;
      Edit_HRetorno1.Text    := QueryL.FieldByName('TrSol_HRet').AsString;  // Data da Abertura
      CBox_AmbSimple.Checked := QueryL.FieldByName('TrSol_BitAmbS').AsBoolean;
      CBox_AmbUTI.Checked := QueryL.FieldByName('TrSol_BitAmbU').AsBoolean;
      CBox_AmbNeo.Checked := QueryL.FieldByName('TrSol_BitAmbN').AsBoolean;
      IF (CBox_AmbSimple.Checked = True) OR (CBox_AmbUTI.Checked = True)
         OR (CBox_AmbNEO.Checked = True) THEN
           Memo_Amb.Enabled := True
      ELSE Memo_Amb.Enabled := False;
      Memo_Amb.Lines.Text   := QueryL.FieldByName('TrSol_AmbJust').AsString;
      Memo_Sol1.Lines.Text  := QueryL.FieldByName('TrSol_Just').AsString;
      Memo_Obs1.Lines.Text  := QueryL.FieldByName('TrSol_Obs').AsString; // Descrição da Solicitação
    End;
End;

////////////////////////////////////////////////////////////////////////////////
//////////////// Botões de Menus ///////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.FirstRegClick(Sender: TObject);
begin
     IF VFBitGrava = True Then Exit;
     IF QueryL.RecordCount = 1 Then Exit;
     QueryL.First;
     Carrega_Dados;
     FirstReg.Enabled := False;  PrevReg.Enabled := False;;
     LastReg.Enabled := True;    NextReg.Enabled := True;
end;

procedure TDlg_SolTrans.PrevRegClick(Sender: TObject);
begin
     IF VFBitGrava = True Then Exit;
     IF QueryL.RecordCount = 1 Then Exit;
     LastReg.Enabled := True;   NextReg.Enabled := True;
     If QueryL.Bof = True Then Begin
        FirstReg.Enabled := False;  PrevReg.Enabled := False; End
     ELSE Begin
       QueryL.Prior;
       Carrega_Dados;
       FirstReg.Enabled := True;   PrevReg.Enabled := True;
     End;
end;

procedure TDlg_SolTrans.NextRegClick(Sender: TObject);
begin
   IF VFBitGrava = True Then Exit;
   IF QueryL.RecordCount = 1 Then Exit;
   FirstReg.Enabled := True;   PrevReg.Enabled := True;
   If QueryL.Eof = True Then Begin
      LastReg.Enabled := False;   NextReg.Enabled := False;  End
   ELSE Begin
      QueryL.Next;
      Carrega_Dados;
      LastReg.Enabled := True;    NextReg.Enabled := True;
   End;
end;

procedure TDlg_SolTrans.LastRegClick(Sender: TObject);
begin
    IF VFBitGrava = True     Then Exit;
    IF QueryL.RecordCount = 1 Then Exit;
    QueryL.Last;
    Carrega_Dados;
    FirstReg.Enabled := True;  PrevReg.Enabled := True;
    LastReg.Enabled := False;  NextReg.Enabled := False;
end;

procedure TDlg_SolTrans.LocalizarClick(Sender: TObject);
begin
    IF VFBitGrava = True Then Exit;
    VgIntScreenMode := VfScreenMode; // Busca de NST
    Pop_Out;
    IF VgStrSQL_Out = '' THEN Exit;
    VfStrSql := VgStrSQL_Out;
    Open_Dados;
    Carrega_Dados;
end;

procedure TDlg_SolTrans.EditarClick(Sender: TObject);
VAR
   BitNovo : Boolean;
begin
    If VfBitGrava = False Then Edit_IN
    ELSE Begin
       Edit_Out;
       IF VfIntIdx = 0 THEN Limpa_Tela
       ELSE Begin
          Seleciona_Registro;
          Carrega_Dados;  End;
    End;
end;

procedure TDlg_SolTrans.NovoRegClick(Sender: TObject);
begin
   IF Vfbitgrava = True Then Exit;
   Limpa_Tela;
   VfIntCodStat := 0;// Código do Status da SS
   VfIntSetor := Dlg_Principal.QueryAcc.FieldByName('Usu_FunCod').AsInteger;
   QueryIn.SQL.Clear;
   QueryIn.SQL.Add('SELECT tb_Setor.Setor_Idx, tb_Setor.Setor_Ccusto, ');
   QueryIN.SQL.Add('tb_Setor.Setor_Setor, tb_Setor.Setor_CodInst, ');
   QueryIN.SQL.Add('Tb_Jurinst.JurI_Nome ');
   QueryIn.SQL.Add('FROM Sginfra.Tb_Setor ');
   QueryIn.SQL.Add('INNER JOIN Sginfra.Tb_Func ON tb_Func.Func_CodSetor = tb_Setor.Setor_Idx ');
   QueryIN.SQL.Add('LEFT JOIN Sginfra.Tb_Jurinst ON Tb_Jurinst.JurI_Idx = tb_Setor.Setor_CodInst ');
   QueryIn.SQL.Add('WHERE tb_Func.Func_Idx =' + IntToStr(VfIntSetor)+ ';');
   QueryIn.Open;
   VfIntSetor   := QueryIN.FieldByName('Setor_Idx').AsInteger;
   VfIntcodInst := QueryIn.FieldByName('Setor_CodInst').AsInteger;
   Edit_Status.Text := 'Aberta';  // Status da SS
   CASE VfScreenMode OF
      701:Begin
            Edit_DtaAb.Text  := DateToStr(Now());  // Data da Abertura
            Edit_Func.Text   := Dlg_Principal.QueryAcc.FieldByName('USU_Nome').AsString; // Nome do Funcionário
            Edit_SetSol.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                                QueryIn.FieldByName('Setor_Setor').AsString;
            Edit_Inst.Text   := QueryIn.FieldByName('JurI_Nome').AsString;
          End;
      702:Begin
            Edit_DtaAb1.Text  := DateToStr(Now());  // Data da Abertura
            Edit_Func1.Text   := Dlg_Principal.QueryAcc.FieldByName('USU_Nome').AsString; // Nome do Funcionário
            Edit_SetSol1.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                                 QueryIn.FieldByName('Setor_Setor').AsString;
            Edit_Inst1.Text   := QueryIn.FieldByName('JurI_Nome').AsString;
          End;
      703:Begin
            IF MessageDlg('Transporte Administrativo?',
               mtConfirmation, [mbYes, mbNo], 0) = mrYes THEN Begin
               TS_ASS.TabVisible := False;     TS_ADM.TabVisible := True;
               Edit_DtaAb.Text := DateToStr(Now());  // Data da Abertura
               Edit_Func.Text   := Dlg_Principal.QueryAcc.FieldByName('USU_Nome').AsString; // Nome do Funcionário
               Edit_SetSol.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                                   QueryIn.FieldByName('Setor_Setor').AsString;
               Edit_Inst.Text   := QueryIn.FieldByName('JurI_Nome').AsString;
               VfBitTipo := True;              End
            ELSE Begin
               TS_ASS.TabVisible := True;      TS_ADM.TabVisible := False;
               Edit_DtaAb1.Text := DateToStr(Now());  // Data da Abertura
               Edit_Func1.Text  := Dlg_Principal.QueryAcc.FieldByName('USU_Nome').AsString; // Nome do Funcionário
               Edit_SetSol1.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                                    QueryIn.FieldByName('Setor_Setor').AsString;
               Edit_Inst1.Text   := QueryIn.FieldByName('JurI_Nome').AsString;
               VfBitTipo := False;             End;
          End;
   End; // Case
   Edit_In;
end;

procedure TDlg_SolTrans.GravarClick(Sender: TObject);
VAR
 DATANOW : TDateTime;
 WARNING : String;
 TDSTR : String;
begin
   IF  VfBitGrava = False Then Exit;
   Edit_Code.SetFocus;
   WARNING := '';
   IF VfBitTipo = True THEN Begin
      IF TRIM(Memo_Sol.Text) = '' THEN WARNING := '(Justificativa)';
      IF (TRIM(Edit_NFunc.Text) = '0') OR (TRIM(Edit_NFunc.Text) = '') THEN
          WARNING := WARNING + ' (Número de Passageiros)';
      IF TRIM(Edit_DtaTrans.Text) = '' THEN WARNING := WARNING + ' (Data do Transporte)';
      IF TRIM(Edit_HIda.Text) = '' THEN WARNING := WARNING + ' (Hora do Transporte)';
      IF (CBox_Retorno.Checked = True)
          AND (TRIM(Edit_HRetorno.Text)='') THEN
              WARNING := WARNING + ' (Data e Hora da Volta)';
      IF TRIM(Edit_Local.Text) = '' THEN WARNING := WARNING + ' (Destino)';  End
   ELSE Begin
      IF TRIM(Memo_Sol1.Text) = '' THEN WARNING := '(Justificativa)';
      IF TRIM(Edit_NomePas.Text) = '' THEN WARNING := WARNING + ' (Nome do Paciente)';
      IF TRIM(Edit_Quarto.Text) = '' THEN WARNING := WARNING + ' (Quarto)';
      IF TRIM(Edit_Leito.Text) = '' THEN WARNING := WARNING + ' (Leito)';
      IF TRIM(Edit_Patologia.Text) = '' THEN WARNING := WARNING + ' (Patologia)';
      IF (TRIM(Edit_IDP.Text) = '0') OR (TRIM(Edit_IDP.Text) = '')THEN
         WARNING := WARNING + ' (Idade do Paciente)';
      IF TRIM(Edit_DtaTrans1.Text) = '' THEN WARNING := WARNING + ' (Data do Transporte)';
      IF TRIM(Edit_HIda1.Text) = '' THEN WARNING := WARNING + ' (Hora do Transporte)';
      IF (CBox_Retorno1.Checked = True)
         AND (TRIM(Edit_HRetorno1.Text)='') THEN
            WARNING := WARNING + ' (Data e Hora da Volta)';
      IF TRIM(Edit_Local1.Text) = '' THEN WARNING := WARNING + ' (Destino)';
      IF ((CBox_AmbSimple.Checked = True) OR (CBox_AmbUTI.Checked = True)
         OR (CBox_AmbNEO.Checked = True)) AND (TRIM(Memo_Amb.Text) = '') THEN
            WARNING := WARNING + ' (Justificativa Ambulância)';
   End;

   IF WARNING <> '' THEN Begin
      MessageDlg('Campos não Preenchido: '+WARNING,  mtWarning, [mbOK], 0);
      Exit ;
   End;

   //// Inserir Novo Registro ////
   IF VfIntIdx = 0 THEN Begin
      DATANOW := Now;
      QueryUpd.Close;
      QueryUpd.SQL.Clear;
      QueryUpd.SQL.Add('INSERT INTO sginfra.tb_TranSol (TrSol_UsuC, TrSol_Status, ');
      QueryUpd.SQL.Add('TrSol_CodStat, TrSol_CodSet, TrSol_Tipo, TrSol_DataC) ');
      QueryUpd.SQL.Add('TrSol_CodInst) ');
      QueryUpd.SQL.Add('VALUES (:U,:S,0,:C,:D,:E,:F);');
      QueryUpd.ParamByName('U').Value := VgIntFunCod;
      QueryUpd.ParamByName('S').Value := 'Aberta'; // 1.Aberta -> 2.Aprovada -> 3.Concluida -> 4.Cancelada
      QueryUpd.ParamByName('C').Value := VfIntSetor;  // Código do Setor
      QueryUpd.ParamByName('D').Value := VfBitTipo;
      QueryUpd.ParamByName('E').Value := DATANOW;
      QueryUpd.ParamByName('F').Value := VfIntCodInst;
      QueryUpd.ExecSQL;

      //// Número da SS ////
      QueryIn.Close;
      QueryIn.SQL.Clear;
      QueryIn.SQL.Add('SELECT TrSol_Idx AS IDX FROM Sginfra.Tb_TranSol ');
      QueryIn.SQL.Add('WHERE tb_TranSol.TrSol_DataC =:B;');
      QueryIn.ParamByName('B').Value := DATANOW;
      QueryIn.Open;

      VfIntIdx := QueryIn.fieldByName('IDX').AsInteger;
      Edit_Code.Text := QueryIn.fieldByName('IDX').AsString;
      VfStrSql := 'WHERE tb_TranSol.TrSol_Idx = ' + Edit_Code.Text ;
   End;

   TDSTR := '';
   IF CBox_AmbSimple.Checked = True THEN TDSTR := 'Ambulância Simples';
   IF CBox_AmbUTI.Checked = True    THEN TDSTR := 'Ambulância UTI';
   IF CBox_AmbNEO.Checked = True    THEN TDSTR := 'Ambulância Neo-Natal';

   QueryUpd.Close;
   QueryUpd.SQL.Clear;
   IF VfBitTipo = True THEN Begin // Transporte Administrativo
     QueryUpd.SQL.Add('UPDATE Sginfra.Tb_TranSol SET TrSol_NSer =:B, ');
     QueryUpd.SQL.Add('TrSol_DtaAg =:C, TrSol_HoraAg =:D, TrSol_BitRet =:E, ');
     QueryUpd.SQL.Add('TrSol_HRet =:F, TrSol_Destino =:G, TrSol_Just =:H, ');
     QueryUpd.SQL.Add('TrSol_Obs =:I, TrSol_DataA =:J, TrSol_NPess =:K ');
     QueryUpd.SQL.Add('WHERE((Tb_TranSol.TrSol_Idx)=:A);');
     QueryUpd.ParamByName('A').Value := VfIntIdx;// Idx
     QueryUpd.ParamByName('B').Value := StrToInt(Edit_Code.Text); // Código da SS
     QueryUpd.ParamByName('C').Value := StrToDate(Edit_DtaTrans.Text);
     QueryUpd.ParamByName('D').Value := Edit_HIda.Text; //
     QueryUpd.ParamByName('E').Value := CBox_Retorno.Checked;
     QueryUpd.ParamByName('F').Value := Edit_HRetorno.Text;
     QueryUpd.ParamByName('G').Value := Edit_Local.Text;
     QueryUpd.ParamByName('H').Value := Memo_Sol.Text;
     QueryUpd.ParamByName('I').Value := Memo_Obs.Lines.Text;
     QueryUpd.ParamByName('J').Value := NOW;
     QueryUpd.ParamByName('K').Value := StrToInt(Edit_NFunc.Text); End
   ELSE Begin // Assistencial
     QueryUpd.SQL.Add('UPDATE Sginfra.Tb_TranSol SET TrSol_NSer =:B, TrSol_DtaAg =:C, ');
     QueryUpd.SQL.Add('TrSol_HoraAg =:D, TrSol_BitRet =:E, TrSol_HRet =:F, ');
     QueryUpd.SQL.Add('TrSol_Destino =:G, TrSol_Just =:H, TrSol_Obs =:I, ');
     QueryUpd.SQL.Add('TrSol_DataA =:J, TrSol_Idade =:K, TrSol_Paciente =:L, ');
     QueryUpd.SQL.Add('TrSol_Leito =:M, TrSol_Quarto =:N, TrSol_Patologia =:O, ');
     QueryUpd.SQL.Add('TrSol_AmbJust =:P, TrSol_BitAmbS =:Q, TrSol_BitAmbU =:R, ');
     QueryUpd.SQL.Add('TrSol_BitAmbN =:S, TrSol_TAmb =:T, TrSol_BitAcom =:U, ');
     QueryUpd.SQL.Add('TrSol_spp =:V ');
     QueryUpd.SQL.Add('WHERE((Tb_TranSol.TrSol_Idx)=:A);');
     QueryUpd.ParamByName('A').Value := VfIntIdx;// Idx
     QueryUpd.ParamByName('B').Value := StrToInt(Edit_Code.Text); // Código da SS
     QueryUpd.ParamByName('C').Value := StrToDate(Edit_DtaTrans1.Text);
     QueryUpd.ParamByName('D').Value := Edit_HIda1.Text; //
     QueryUpd.ParamByName('E').Value := CBox_Retorno1.Checked;
     QueryUpd.ParamByName('F').Value := Edit_HRetorno1.Text;
     QueryUpd.ParamByName('G').Value := Edit_Local1.Text;
     QueryUpd.ParamByName('H').Value := Memo_Sol1.Text;
     QueryUpd.ParamByName('I').Value := Memo_Obs1.Lines.Text;
     QueryUpd.ParamByName('J').Value := NOW;
     QueryUpd.ParamByName('K').Value := StrToInt(Edit_IDP.Text);
     QueryUpd.ParamByName('L').Value := TRIM(Edit_NomePas.Text);
     QueryUpd.ParamByName('M').Value := Edit_Leito.Text;
     QueryUpd.ParamByName('N').Value := Edit_Quarto.Text;
     QueryUpd.ParamByName('O').Value := Edit_Patologia.Text;
     QueryUpd.ParamByName('P').Value := Memo_Amb.Text;
     QueryUpd.ParamByName('Q').Value := CBox_AmbSimple.Checked;
     QueryUpd.ParamByName('R').Value := CBox_AmbUti.Checked;
     QueryUpd.ParamByName('S').Value := CBox_AmbNeo.Checked;
     QueryUpd.ParamByName('T').Value := TDSTR;
     QueryUpd.ParamByName('U').Value := CBox_Acomp.Checked;
     QueryUpd.ParamByName('V').Value := StrToInt(Edit_SPP.Text);
   END;
   QueryUpd.ExecSQL;
   // Arquivo Log
   Edit_Out;
   Salva_Log;

   Open_Dados;
   Seleciona_Registro;
   Carrega_Dados;
end;

procedure TDlg_SolTrans.ImprimirClick(Sender: TObject);
begin
   VgStrSQL_In := 'WHERE (Tb_TranSol.TrSol_Idx = ' + IntToStr(VfIntIdx) + ')' ;
   Application.CreateForm(TForm_SolTransporte, Form_SolTransporte);
   Form_SolTransporte.QuickRep1.Preview;
   Form_SolTransporte.Destroy;
end;

procedure TDlg_SolTrans.SaidaClick(Sender: TObject);
begin
  Close;
end;


////////////////////////////////////////////////////////////////////////////////
///////////////////// Rotinas dos Edits ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.Edit_CodeKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF  VfBitGrava = True Then Exit;
   IF (Key = 46) Then Edit_Code.Text := '';
   IF (Key = 13) Then Begin // Tecla Enter
      Edit_Code.Text := Dlg_Principal.Valida_Numero(Edit_Code.Text,0);
      IF Trim(Edit_Code.Text) = '' Then Exit;
      VfStrSql := 'WHERE (Tb_TranSol.TrSol_NSer = ' + Trim(Edit_Code.Text)+ ')';
      IF VfScreenMode <> 703 THEN Begin
         VfStrSql := VfStrSql + 'AND(Tb_TranSol.TrSol_Tipo IS ';
         IF VfBitTipo = TRUE THEN VfStrSql := VfStrSql + 'TRUE )'
         ELSE VfStrSql := VfStrSql + 'FALSE )'; End;
      Open_Dados;
      Carrega_Dados;
   End;
end;

procedure TDlg_SolTrans.Edit_SetSolKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
    IF VfBitGrava = False Then Begin
       IF VfBitTipo = True THEN Edit_NFunc.SetFocus
       ELSE Edit_NomePas.SetFocus;
       Exit;
    End;
    IF (Key = 114) AND (Editar.Visible = True) Then Begin   // F3 -> 114
        VgIntScreenMode := 196; // Setor
        VgStrSQL_In := 'WHERE Tb_Setor.Setor_Idx = '+IntToStr(VfIntSetor);
        Pop_Out;
        Exit;
     End;
    IF (Key = 118) Then Begin  // F7 -> Key 118
        VgIntScreenMode := 106; // Setor
        VgStrSQL_IN := '';
        Pop_Out;
        IF VgStrSQL_Out = '' Then Exit ;
        QueryIn.SQL.Clear;
        QueryIn.SQL.Add('SELECT tb_Setor.Setor_Ccusto,tb_Setor.Setor_Setor, ');
        QueryIn.SQL.Add('tb_Setor.Setor_Idx FROM Sginfra.Tb_Setor ');
        QueryIn.SQL.Add(VgStrSQL_Out+ ';');
        QueryIn.Open;
        VfIntSetor       := QueryIn.FieldByName('Setor_Idx').AsInteger;
        Edit_SetSol.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                            QueryIn.FieldByName('Setor_Setor').AsString;
        Edit_SetSol1.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                            QueryIn.FieldByName('Setor_Setor').AsString;
     End;
    IF (Key = 13) THEN Begin
        IF VfScreenMode = 702 THEN Edit_SetSol.Text := Edit_SetSol1.Text;
        IF Edit_SetSol.Text = '' THEN Exit;
        QueryIn.Close;
        QueryIn.SQL.Clear;
        QueryIn.SQL.Add('SELECT Setor_Ccusto, Setor_Setor, Setor_Resp, Setor_Idx ');
        QueryIn.SQL.Add('FROM Sginfra.Tb_Setor WHERE Setor_Ccusto = '+ Edit_SetSol.Text + ';');
        QueryIn.Open;
        VfIntSetor       := QueryIn.FieldByName('Setor_Idx').AsInteger;
        Edit_SetSol.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                            QueryIn.FieldByName('Setor_Setor').AsString;
        Edit_SetSol1.Text := QueryIn.FieldByName('Setor_Ccusto').AsString+' - '+
                            QueryIn.FieldByName('Setor_Setor').AsString;
     END;
    IF (Key = 46)OR(Key = 8) Then Begin  // Del Key
        Edit_SetSol.Text := '';
        Edit_SetSol1.Text := '';
        VfIntSetor   :=  0;
    END;  
end;

procedure TDlg_SolTrans.Edit_NFuncExit(Sender: TObject);
begin
   IF  VfBitGrava = False Then Exit;
   Edit_NFunc.Text := Dlg_Principal.Valida_Numero(Edit_NFunc.Text,0);
   IF Edit_NFunc.Text = '0' THEN Edit_NFunc.Text := '1';
end;

procedure TDlg_SolTrans.Edit_NFuncKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
    IF Key = 13 THEN Edit_DtaTrans.SetFocus;
End;

procedure TDlg_SolTrans.Edit_DtaTransExit(Sender: TObject);
begin
    IF VfBitGrava = False Then Exit;
    IF VfBitTipo = True THEN
       Edit_DtaTrans.Text := Dlg_Principal.Valida_Data(Edit_DtaTrans.Text,1)
    ELSE
       Edit_DtaTrans1.Text := Dlg_Principal.Valida_Data(Edit_DtaTrans1.Text,1);
end;

procedure TDlg_SolTrans.Edit_DtaTransKeyDown(Sender: TObject;  var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF VfBitTipo = True THEN Edit_HIda.SetFocus
      ELSE Edit_HIda1.SetFocus;
end;

procedure TDlg_SolTrans.Edit_HIdaExit(Sender: TObject);
begin
   IF  VfBitGrava = False Then Exit;
   IF VfBitTipo = True THEN
      Edit_HIda.Text := Dlg_Principal.Valida_Hora(Edit_HIda.Text,0)
   ELSE Edit_HIda1.Text := Dlg_Principal.Valida_Hora(Edit_HIda1.Text,0);
end;

procedure TDlg_SolTrans.Edit_HIdaKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF VfBitTipo = True THEN Edit_Local.SetFocus
      ELSE Edit_Local1.SetFocus;
end;

procedure TDlg_SolTrans.Edit_LocalKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF VfBitTipo = True THEN CBox_Retorno.SetFocus
      ELSE CBox_Retorno1.SetFocus;
end;

procedure TDlg_SolTrans.CBox_RetornoClick(Sender: TObject);
begin
   Edit_HRetorno.Enabled := CBox_Retorno.Checked;
   IF CBox_Retorno.Checked = True THEN Begin
      Edit_HRetorno.Text  := Edit_DtaTrans.Text;
      Edit_HRetorno1.Text := Edit_DtaTrans1.Text;   End
   ELSE Begin
      Edit_HRetorno.Text  := '';
      Edit_HRetorno1.Text := '';
   End;
end;

procedure TDlg_SolTrans.CBox_RetornoKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF CBox_Retorno.Checked = True THEN Edit_HRetorno.SetFocus
      ELSE Memo_Sol.SetFocus;
end;

procedure TDlg_SolTrans.Edit_HRetornoExit(Sender: TObject);
begin
   IF  VfBitGrava = False Then Exit;
   IF VfBitTipo = True THEN
       Edit_HRetorno.Text := Dlg_Principal.Valida_Data(Edit_HRetorno.Text,1)
   ELSE
       Edit_HRetorno1.Text := Dlg_Principal.Valida_Data(Edit_HRetorno1.Text,1);
end;

procedure TDlg_SolTrans.Edit_HRetornoKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF VfBitTipo = True THEN Memo_Sol.SetFocus
      ELSE Memo_Sol1.SetFocus;
end;

procedure TDlg_SolTrans.Memo_SolKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
VAR
  X : Integer;
  S,T : String;
begin
   IF Key = 13 THEN BEGIN
      X := LENGTH(Memo_Sol.Text);
      T := Memo_Sol.Text;
      WHILE X > 1 Do Begin
          S := T[X];
          IF (S = CHR(13))OR(S = CHR(10)) THEN T[X] := ' ';
          DEC(X); End;
      Memo_Sol.Text := T;
      Memo_OBS.SetFocus
   END;
end;

procedure TDlg_SolTrans.Memo_ObsKeyDown(Sender: TObject; var Key: Word;  Shift: TShiftState);
VAR
  X : Integer;
  S,T : String;
begin
   IF Key = 13 THEN Begin
      X := LENGTH(Memo_Obs.Text);
      T := Memo_Obs.Text;
      WHILE X > 1 Do Begin
          S := T[X];
          IF (S = CHR(13))OR(S = CHR(10)) THEN T[X] := ' ';
          DEC(X); End;
      Memo_Obs.Text := T;
      Edit_Code.SetFocus;
   End;
end;


procedure TDlg_SolTrans.Edit_SPPKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF (Key = 13) THEN Begin
      IF (VfBitGrava = False) THEN Edit_NomePas.SetFocus
      ELSE Open_Sigh;
   End;
end;


procedure TDlg_SolTrans.Edit_NomePasKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN Edit_Quarto.SetFocus;
end;

procedure TDlg_SolTrans.Edit_QuartoKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN Edit_Leito.SetFocus;
end;

procedure TDlg_SolTrans.Edit_LeitoKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN Edit_IDP.SetFocus;
end;

procedure TDlg_SolTrans.Edit_IDPExit(Sender: TObject);
begin
   IF  VfBitGrava = False Then Exit;
   Edit_IDP.Text := Dlg_Principal.Valida_Numero(Edit_IDP.Text,0);
end;

procedure TDlg_SolTrans.Edit_IDPKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN Edit_Patologia.SetFocus;
end;

procedure TDlg_SolTrans.Edit_PatologiaKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN CBox_Acomp.SetFocus;
end;

procedure TDlg_SolTrans.CBox_AcompKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN Edit_DtaTrans1.SetFocus;
end;

procedure TDlg_SolTrans.CBox_Retorno1Click(Sender: TObject);
begin
   Edit_HRetorno1.Enabled := CBox_Retorno1.Checked;
end;

procedure TDlg_SolTrans.CBox_Retorno1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF CBox_Retorno1.Checked = True THEN Edit_HRetorno1.SetFocus
      ELSE Memo_Sol1.SetFocus;
end;

procedure TDlg_SolTrans.CBox_AmbSimpleKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
   IF Key = 13 THEN
      IF (CBox_AmbSimple.Checked = True) OR (CBox_AmbUTI.Checked = True)
         OR (CBox_AmbNEO.Checked = True) AND (TRIM(Memo_Amb.Text) = '') THEN
             Memo_Amb.SetFocus
      ELSE Memo_OBS1.SetFocus;
end;

procedure TDlg_SolTrans.CBox_AmbSimpleClick(Sender: TObject);
begin
   IF (CBox_AmbSimple.Checked = True) THEN Begin
      CBox_AmbUTI.Checked := False;   CBox_AmbNEO.Checked := False;
      Memo_Amb.Enabled := True;       Lbl_JusAmb.Enabled := True;
      Imprimir.Enabled := True;       End
   ELSE Begin
      Memo_Amb.Enabled := False;      Lbl_JusAmb.Enabled := False;
      Imprimir.Enabled := False;      End;
end;

procedure TDlg_SolTrans.CBox_AmbUTIClick(Sender: TObject);
begin
   IF (CBox_AmbUTI.Checked = True) THEN Begin
      CBox_AmbSimple.Checked := False;   CBox_AmbNEO.Checked := False;
      Memo_Amb.Enabled := True;          Lbl_JusAmb.Enabled := True;
      Imprimir.Enabled := True;          End
   ELSE Begin
      Memo_Amb.Enabled := False;         Lbl_JusAmb.Enabled := False;
      Imprimir.Enabled := False;         End;
end;

procedure TDlg_SolTrans.CBox_AmbNeoClick(Sender: TObject);
begin
   IF (CBox_AmbNEO.Checked = True) THEN Begin
      CBox_AmbSimple.Checked := False;   CBox_AmbUTI.Checked := False;
      Memo_Amb.Enabled := True;          Lbl_JusAmb.Enabled := True;
      Imprimir.Enabled := True;          End
   ELSE Begin
      Memo_Amb.Enabled := False;         Lbl_JusAmb.Enabled := False;
      Imprimir.Enabled := False;         End;
end;

procedure TDlg_SolTrans.Memo_AmbKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
VAR
  X : Integer;
  S,T : String;
begin
   IF Key = 13 THEN BEGIN
      X := LENGTH(Memo_Amb.Text);
      T := Memo_Amb.Text;
      WHILE X > 1 Do Begin
          S := T[X];
          IF (S = CHR(13))OR(S = CHR(10)) THEN T[X] := ' ';
          DEC(X); End;
      Memo_Amb.Text := T;
      Memo_OBS1.SetFocus;
   End;
end;

procedure TDlg_SolTrans.Memo_Sol1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
VAR
  X : Integer;
  S,T : String;
begin
   IF Key = 13 THEN BEGIN
      X := LENGTH(Memo_Sol1.Text);
      T := Memo_Obs.Text;
      WHILE X > 1 Do Begin
          S := T[X];
          IF (S = CHR(13))OR(S = CHR(10)) THEN T[X] := ' ';
          DEC(X); End;
      Memo_Sol1.Text := T;
      CBox_AmbSimple.SetFocus;
   End;
end;

procedure TDlg_SolTrans.Memo_OBS1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
VAR
  X : Integer;
  S,T : String;
begin
   IF Key = 13 THEN Begin
      X := LENGTH(Memo_Obs1.Text);
      T := Memo_Obs.Text;
      WHILE X > 1 Do Begin
          S := T[X];
          IF (S = CHR(13))OR(S = CHR(10)) THEN T[X] := ' ';
          DEC(X); End;
      Memo_Obs1.Text := T;
      Memo_Sol1.SetFocus;
   End;
end;

////////////////////////////////////////////////////////////////////////////////
/////////////////////// Botões Extras //////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.BtnCancClick(Sender: TObject);
VAR
  DATASTR : String;
begin
   IF MessageDlg('Deseja Realmente Cancelar esta Solicitação de Transporte',
                  mtConfirmation, [mbYes, mbNo], 0) = mrNo then  Exit;
   DATASTR := InputBox('Cancelamento da Solicitação de Serviço',
                       'Motivo do Cancelamento', '');

   IF VfBitTipo = True THEN VfStrValDta := Edit_CodSol.Text
   ELSE VfStrValDta := Edit_CodSol1.Text;

   QueryUpd.Close;
   QueryUpd.SQL.Clear;
   QueryUpd.SQL.Add('UPDATE Sginfra.Tb_TranSol SET TrSol_DataCanc =:E, ');  // 4
   QueryUpd.SQL.Add('TrSol_CodCanc =:B, TrSol_MotCanc =:C, '); // 3
   QueryUpd.SQL.Add('TrSol_Status =:D, TrSol_CodStat = 4 '); // 3
   QueryUpd.SQL.Add('WHERE((TrSol_Idx)=:A);');   // 1
   QueryUpd.ParamByName('A').Value := VfIntIdx;
   QueryUpd.ParamByName('B').Value := VgIntFunCod;// Código do Funcionário que cancelou a SS
   QueryUpd.ParamByName('C').Value := Trim(DATASTR);  // Motivo do Cancelamento
   QueryUpd.ParamByName('D').Value := 'Cancelada';// Setor Code
   QueryUpd.ParamByName('E').Value := NOW; //  Status
   QueryUpd.ExecSQL;

//////////// Marca Transporte
   IF VfIntCodStat = 2 Then Begin
      QueryUpd.Close;
      QueryUpd.SQL.Clear;
      QueryUpd.SQL.Add('UPDATE Sginfra.Tb_Transporte SET Trans_CodStat = 4, Trans_UsuA =:C ');
      QueryUpd.SQL.Add('WHERE (Trans_CodSol =:A); ');
      QueryUpd.ParamByName('A').Value := QueryL.FieldByName('TrSol_NSer').AsString;
      QueryUpd.ParamByName('C').Value := VgIntUsuCod;// Código do Funcionário que Aprovou
      QueryUpd.ExecSQL;
   End;

   Salva_Log;
   Edit_Out;
   Open_Dados;
   Seleciona_Registro;
   Carrega_Dados;
end;

procedure TDlg_SolTrans.BtnApClick(Sender: TObject);
VAR
  IDX : Integer;
begin
    IF VfIntCodStat = 4 Then Begin
       MessageDlg('Solicitação Cancelada', mtWarning, [mbOk], 0); Exit; END;

    IF MessageDlg('Aprovar a Solicitação?', mtWarning, [mbYES,mbNO], 0)= mrNO THEN Exit;

//////////// Aprova a ST
    QueryUpd.Close;
    QueryUpd.SQL.Clear;
    QueryUpd.SQL.Add('UPDATE Sginfra.Tb_TranSol SET TrSol_DataAprov =:B, ');
    QueryUpd.SQL.Add('TrSol_CodApro =:C, TrSol_Status =:D, ');
    QueryUpd.SQL.Add('TrSol_CodStat = 1, TrSol_DataA =:E ');
    QueryUpd.SQL.Add('WHERE((TrSol_Idx)=:A);');   // 1
    QueryUpd.ParamByName('A').Value := VfIntIdx;
    QueryUpd.ParamByName('B').Value := NOW; //  Status
    QueryUpd.ParamByName('C').Value := VgIntFunCod;// Código do Funcionário que Aprovou
    QueryUpd.ParamByName('D').Value := 'Aprovada';// Setor Code
    QueryUpd.ParamByName('E').Value := NOW; //  Status
    QueryUpd.ExecSQL;

//////////// Marca Transporte
    QueryUpd.Close;
    QueryUpd.SQL.Clear;
    QueryUpd.SQL.Add('INSERT INTO sginfra.tb_Transporte (Trans_CodSol, Trans_Hora, ');
    QueryUpd.SQL.Add('Trans_BitRet, Trans_DtaTrans, Trans_UsuC,  Trans_DataC) ');
    QueryUpd.SQL.Add('VALUES (:A,:B,False,:C,:D,:E);');
    QueryUpd.ParamByName('A').Value := QueryL.FieldByName('TrSol_NSer').AsString;
    QueryUpd.ParamByName('B').Value := QueryL.FieldByName('TrSol_HoraAg').AsString;
    QueryUpd.ParamByName('C').Value := QueryL.FieldByName('TrSol_DtaAg').AsString;
    QueryUpd.ParamByName('D').Value := VgIntFunCod;// Código do Funcionário que Aprovou
    QueryUpd.ParamByName('E').Value := NOW;
    QueryUpd.ExecSQL;

//////////// Tipo de Transporte
    IF (CBox_Retorno.Checked = True)
       OR (CBox_Retorno1.Checked = True) THEN Begin
       QueryUpd.Close;
       QueryUpd.SQL.Clear;
       QueryUpd.SQL.Add('INSERT INTO sginfra.tb_Transporte (Trans_CodSol, Trans_Hora, ');
       QueryUpd.SQL.Add('Trans_BitRet, Trans_DtaTrans, Trans_UsuC, Trans_DataC) ');
       QueryUpd.SQL.Add('VALUES (:A,:B,True,:C,:D,:E);');
       QueryUpd.ParamByName('A').Value := QueryL.FieldByName('TrSol_NSer').AsString;
       QueryUpd.ParamByName('B').Value := QueryL.FieldByName('TrSol_HRet').AsString;
       QueryUpd.ParamByName('C').Value := QueryL.FieldByName('TrSol_DtaAg').AsString;
       QueryUpd.ParamByName('D').Value := VgIntFunCod;// Código do Funcionário que Aprovou
       QueryUpd.ParamByName('E').Value := NOW;
       QueryUpd.ExecSQL;
    End;
    Salva_Log;
    Edit_Out;
    Open_Dados;
    Seleciona_Registro;
    Carrega_Dados;
end;

////////////////////////////////////////////////////////////////////////////////
//////////////////// Sub-Rotinas PopUp e PopOut ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.Pop_Out;
var
   BuscaCadastro : TDlg_BuscaCadastro;
   BuscaTransp   : TDlg_BuscaTransp;
   Setor         : TDlg_Setor;
begin
  CASE VgIntScreenMode OF
    104,106,109:begin
          try BuscaCadastro:= TDlg_BuscaCadastro.Create (self);
          BuscaCadastro.ShowModal;
          finally  BuscaCadastro.free; end;
        End;
    196:Begin // Setor
          VgIntScreenMode := VgIntScreenMode - 90;
          Setor:= TDlg_Setor.Create (self);
          Setor.Show;
        End;
    701,702,703:Begin // Busca Nº ST
          TRY  BuscaTransp:= TDlg_BuscaTransp.Create (self); BuscaTransp.ShowModal;
          FINALLY BuscaTransp.free; END;
        End;
   END; // Case
End;

////////////////////////////////////////////////////////////////////////////////
///////////////// Rotianas de Gravação no Banco de Dados ///////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.Salva_Log;
begin
    QueryUpd.Close;
    QueryUpd.SQL.Clear;
    QueryUpd.SQL.Add('INSERT INTO sginfra.tb_Log (Log_Usuario, Log_CodFun, ');
    QueryUpd.SQL.Add('Log_Data, Log_Tab, Log_Reg, Log_Status) ');
    QueryUpd.SQL.Add('VALUES (:U,:C,:D,:T,:R,:S)');
    QueryUpd.ParamByName('U').Value := VgIntUsuCod;
    QueryUpd.ParamByName('C').Value := VgIntFunCod;
    QueryUpd.ParamByName('D').Value := Now;
    QueryUpd.ParamByName('T').Value := 'Solicitação de Transporte';
    QueryUpd.ParamByName('R').Value := VfIntIdx;   // Idx
    QueryUpd.ParamByName('S').Value := Edit_Status.Text;
    QueryUpd.ExecSQL;
end;

////////////////////////////////////////////////////////////////////////////////
///////////////// Outras Sub-Rotinas ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

procedure TDlg_SolTrans.Limpa_Tela;
Begin
    //// Menu ////
    VfBitGrava := False;              VfIntIdx   := 0;
    VfIntCodStat := 0;                VfIntSetor := 0;

    //// Cabeçalho ////
    Edit_Code.Text := '';
    Editar.Enabled := False;          Imprimir.Enabled := False;
    BtnAp.Enabled := False;           BtnCanc.Enabled := False;

    /////// Pagina 1
    Edit_CodSol.Text := '';           Edit_DtaAb.Text := '';
    Edit_Status.Text := '';           Edit_Func.Text  := '';
    Edit_SetSol.Text := '';           Edit_NFunc.Text := '';
    Edit_DtaTrans.Text := '';         Edit_HIda.Text  := '';
    Edit_Local.Text  := '';
    CBox_Retorno.Checked := False;    CBox_Retorno.DragMode := dmAutomatic;
    Edit_HRetorno.Text := '';         Edit_HRetorno.Enabled := False;
    Memo_Sol.Lines.Text := '';        Memo_Obs.Lines.Text := '';

   //////// Pagina 2
    Edit_CodSol1.Text := '';          Edit_DtaAb1.Text  := '';
    Edit_Func1.Text   := '';
    Edit_SetSol1.Text := '';          Edit_NomePas.Text := '';
    Edit_Quarto.Text  := '';          Edit_Leito.Text   := '';
    Edit_IDP.Text     := '';          Edit_Patologia.Text := '';
    CBox_Acomp.Checked := False;      CBox_Acomp.DragMode := dmAutomatic;
    Edit_DtaTrans1.Text := '';
    Edit_HIda1.Text   := '';          Edit_Local1.Text  := '';
    CBox_Retorno1.Checked := False;   CBox_Retorno1.DragMode := dmAutomatic;
    Edit_HRetorno1.Text := '';        Edit_HRetorno1.Enabled := False ;
    CBox_AmbSimple.Checked := False;  CBox_AmbSimple.DragMode := dmAutomatic;
    CBox_AmbUTI.Checked := False;     CBox_AmbUTI.DragMode := dmAutomatic;
    CBox_AmbNEO.Checked := False;     CBox_Ambneo.DragMode := dmAutomatic;
    Memo_Amb.Lines.Text := '';        Memo_Amb.Enabled := False;
    Memo_Sol1.Lines.Text := '';       Memo_Obs1.Lines.Text := '';
End;

procedure TDlg_SolTrans.Edit_IN;
Begin
   BtnAp.Enabled := False;         BtnCanc.Enabled := False;
   NovoReg.Enabled := False;       Localizar.Enabled := False;
   Gravar.Enabled  := True;        Editar.Enabled := True;
   Editar.ShortCut := 0;           Localizar.ShortCut := 0;
   VfBitGrava := True;

   Edit_Code.ReadOnly := True;             Edit_SPP.ReadOnly := False;
   IF VfBitTipo = True THEN Begin // Adm
      Edit_SetSol.ReadOnly := False;       Edit_NFunc.ReadOnly := False;
      Edit_DtaTrans.ReadOnly := False;     Edit_HIda.ReadOnly := False;
      Edit_Local.ReadOnly := False;        CBox_Retorno.DragMode := dmManual;
      Edit_HRetorno.ReadOnly := False;     Edit_HRetorno.ReadOnly := False;
      Memo_Sol.ReadOnly := False;          Memo_OBS.ReadOnly := False;       End
   ELSE Begin // ASS
      Edit_SetSol1.ReadOnly := False;      Edit_NomePas.ReadOnly := False;
      Edit_Quarto.ReadOnly := False;       Edit_Leito.ReadOnly := False;
      Edit_IDP.ReadOnly := False;          Edit_Patologia.ReadOnly := False;
      CBox_Acomp.DragMode := dmManual;
      Edit_DtaTrans1.ReadOnly := False;    Edit_HIda1.ReadOnly := False;
      Edit_Local1.ReadOnly := False;
      CBox_Retorno1.DragMode := dmManual;
      Edit_HRetorno1.ReadOnly := False;
      CBox_AmbSimple.DragMode := dmManual;
      CBox_AmbUTI.DragMode := dmManual;
      CBox_Ambneo.DragMode := dmManual;
      Memo_Amb.ReadOnly := False;          Memo_Sol1.ReadOnly := False;
      Memo_OBS1.ReadOnly := False;
    END;
End;

procedure TDlg_SolTrans.Edit_Out;
Begin
    Editar.Enabled := False;    Gravar.Enabled  := False;
    Refresh.Enabled := False;   BtnAp.Enabled := True;
    BtnCanc.Enabled := True;    VfBitGrava := True;
    Editar.ShortCut := 114;     Localizar.ShortCut := 118;
    Localizar.Enabled := True;  NovoReg.Enabled := True;
    VfBitGrava := False;

    Edit_Code.ReadOnly := False;           Edit_SPP.ReadOnly := True;
    IF VfBitTipo = True THEN Begin // Adm
       Edit_SetSol.ReadOnly := True;       Edit_NFunc.ReadOnly := True;
       Edit_DtaTrans.ReadOnly := True;     Edit_HIda.ReadOnly := True;
       Edit_Local.ReadOnly := True;        CBox_Retorno.DragMode := dmAutomatic;
       Edit_HRetorno.ReadOnly := True;     Edit_HRetorno.ReadOnly := True;
       Memo_Sol.ReadOnly := True;          Memo_OBS.ReadOnly := True;        End
    ELSE Begin // ASS
       Edit_SetSol1.ReadOnly := True;      Edit_NomePas.ReadOnly := True;
       Edit_Quarto.ReadOnly := True;       Edit_Leito.ReadOnly := True;
       Edit_IDP.ReadOnly := True;          Edit_Patologia.ReadOnly := True;
       CBox_Acomp.DragMode := dmAutomatic;
       Edit_DtaTrans1.ReadOnly := True;    Edit_HIda1.ReadOnly := True;
       Edit_Local1.ReadOnly := True;
       CBox_Retorno1.DragMode := dmAutomatic;
       Edit_HRetorno1.ReadOnly := True;
       CBox_AmbSimple.DragMode := dmAutomatic;
       CBox_AmbUTI.DragMode := dmAutomatic;
       CBox_AmbNEO.DragMode := dmAutomatic;
       Memo_Amb.ReadOnly := True;          Memo_Sol1.ReadOnly := True;
       Memo_OBS1.ReadOnly := True;
    END; // CASE
End;

procedure TDlg_SolTrans.Seleciona_Registro;
Var
  VlStr : String;
  VlInt : Integer;
begin
  VlStr := Trim(Edit_CodSol.Text);
  if VlStr = '' then exit;
  VlInt := StrToInt(VlStr);
  QueryL.First;
  While (((QueryL.FieldByName('TrSol_Idx').AsInteger) <> VlInt )AND(QueryL.Eof = False))
       Do QueryL.Next;
  FirstReg.Enabled := True;  PrevReg.Enabled := True;
  IF QueryL.Eof = True THEN Begin
     LastReg.Enabled := False;  NextReg.Enabled := False; End
  ELSE Begin
     LastReg.Enabled := True;   NextReg.Enabled := True;
  End;
End;
