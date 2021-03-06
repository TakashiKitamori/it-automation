<?php
//   Copyright 2019 NEC Corporation
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.
//
//////////////////////////////////////////////////////////////////////
//
//  【処理概要】
//    ・Ansible（Legacy Role）メンバー変数管理
//
//////////////////////////////////////////////////////////////////////

$tmpFx = function (&$aryVariant=array(),&$arySetting=array()){
    global $g;

    $arrayWebSetting = array();
    $arrayWebSetting['page_info'] = $g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1701010");
/*
Ansible（Legacy Role）ロール変数名管理
*/
    $tmpAry = array(
        'TT_SYS_01_JNL_SEQ_ID'=>'JOURNAL_SEQ_NO',
        'TT_SYS_02_JNL_TIME_ID'=>'JOURNAL_REG_DATETIME',
        'TT_SYS_03_JNL_CLASS_ID'=>'JOURNAL_ACTION_CLASS',
        'TT_SYS_04_NOTE_ID'=>'NOTE',
        'TT_SYS_04_DISUSE_FLAG_ID'=>'DISUSE_FLAG',
        'TT_SYS_05_LUP_TIME_ID'=>'LAST_UPDATE_TIMESTAMP',
        'TT_SYS_06_LUP_USER_ID'=>'LAST_UPDATE_USER',
        'TT_SYS_NDB_ROW_EDIT_BY_FILE_ID'=>'ROW_EDIT_BY_FILE',
        'TT_SYS_NDB_UPDATE_ID'=>'WEB_BUTTON_UPDATE',
        'TT_SYS_NDB_LUP_TIME_ID'=>'UPD_UPDATE_TIMESTAMP'
    );

    $table = new TableControlAgent('B_ANSIBLE_LRL_CHILD_VARS','CHILD_VARS_NAME_ID', $g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1701020"), 'B_ANSIBLE_LRL_CHILD_VARS_JNL', $tmpAry);
    $tmpAryColumn = $table->getColumns();
    $tmpAryColumn['CHILD_VARS_NAME_ID']->setSequenceID('B_ANSIBLE_LRL_CHILD_VARS_RIC');
    $tmpAryColumn['JOURNAL_SEQ_NO']->setSequenceID('B_ANSIBLE_LRL_CHILD_VARS_JSQ');
    unset($tmpAryColumn);

    // QMファイル名プレフィックス
    $table->setDBMainTableLabel($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1701030"));
    // エクセルのシート名
    $table->getFormatter('excel')->setGeneValue('sheetNameForEditByFile',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1701040"));


    //---- 検索機能の制御
    $table->setGeneObject('AutoSearchStart',true);  //('',true,false)
    // 検索機能の制御----



    $c = new IDColumn('PARENT_VARS_NAME_ID',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1702010"),'B_ANSIBLE_LRL_VARS_MASTER','VARS_NAME_ID','VARS_NAME','');
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1702020"));//エクセル・ヘッダでの説明
    $c->setJournalTableOfMaster('B_ANSIBLE_LRL_VARS_MASTER_JNL');
    $c->setJournalSeqIDOfMaster('JOURNAL_SEQ_NO');
    $c->setJournalLUTSIDOfMaster('LAST_UPDATE_TIMESTAMP');
    $c->setJournalKeyIDOfMaster('VARS_NAME_ID');
    $c->setJournalDispIDOfMaster('VARS_NAME');
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    $objVldt = new SingleTextValidator(1,1024,false);
    $c = new TextColumn('CHILD_VARS_NAME',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1703010"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1703020"));//エクセル・ヘッダでの説明
    $c->setValidator($objVldt);
    $c->setRequired(true);//登録/更新時には、入力必須
    $table->addColumn($c);

    $c = new NumColumn('ARRAY_MEMBER_ID',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305100"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305110"));//エクセル・ヘッダでの説明
    $c->setSubtotalFlag(false);
    $c->setValidator(new IntNumValidator(null,null));
    $table->addColumn($c);

    $c = new NumColumn('ASSIGN_SEQ_NEED',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305120"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305130"));//エクセル・ヘッダでの説明
    $c->setSubtotalFlag(false);
    $c->setValidator(new IntNumValidator(null,null));
    $table->addColumn($c);

    $c = new NumColumn('COL_SEQ_NEED',$g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305140"));
    $c->setDescription($g['objMTS']->getSomeMessage("ITAANSIBLEH-MNU-1305150"));//エクセル・ヘッダでの説明
    $c->setSubtotalFlag(false);
    $c->setValidator(new IntNumValidator(null,null));
    $table->addColumn($c);

    $table->fixColumn();

    $table->setGeneObject('webSetting', $arrayWebSetting);
    return $table;
};
loadTableFunctionAdd($tmpFx,__FILE__);
unset($tmpFx);
?>
