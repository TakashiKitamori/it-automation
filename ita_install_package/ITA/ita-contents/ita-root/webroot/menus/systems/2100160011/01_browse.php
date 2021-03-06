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

    $tmpAry=explode('ita-root', dirname(__FILE__));$root_dir_path=$tmpAry[0].'ita-root';unset($tmpAry);

    //-- サイト個別PHP要素、ここから--
    //-- サイト個別PHP要素、ここまで--
//    require_once ( $root_dir_path . "/libs/webcommonlibs/table_control_agent/web_parts_for_template_01_browse.php");

    global $g;
    // ルートディレクトリを取得
    $tmpAry=explode('ita-root', dirname(__FILE__));$g['root_dir_path']=$tmpAry[0].'ita-root';unset($tmpAry);
    if(array_key_exists('no', $_GET)){
        $g['page_dir']  = $_GET['no'];
    }

/*
    $param = explode ( "?" , $_SERVER["REQUEST_URI"] , 2 );
    if(count($param) == 2){
        $url_add_param = "&" . $param[1];
    }
    else{
        $url_add_param = "";
    }
*/
    // DBアクセスを伴う処理を開始
    try{
        //----ここから01_系から06_系全て共通
        // DBコネクト
        require_once ( $g['root_dir_path'] . "/libs/commonlibs/common_php_req_gate.php");
        // 共通設定取得パーツ
        require_once ( $g['root_dir_path'] . "/libs/webcommonlibs/web_parts_get_sysconfig.php");
        // メニュー情報取得パーツ
        require_once ( $g['root_dir_path'] . "/libs/webcommonlibs/web_parts_menu_info.php");
        //ここまで01_系から06_系全て共通----

        // browse系共通ロジックパーツ01
        require_once ( $g['root_dir_path'] . "/libs/webcommonlibs/web_parts_for_browse_01.php");
    }
    catch (Exception $e){
        // DBアクセス例外処理パーツ
        require_once ( $g['root_dir_path'] . "/libs/webcommonlibs/web_parts_db_access_exception.php");
    }

    $strCmdWordAreaOpen = $g['objMTS']->getSomeMessage("ITAWDCH-STD-251");
    $strCmdWordAreaClose = $g['objMTS']->getSomeMessage("ITAWDCH-STD-252");
    $confirmMessage = $g['objMTS']->getSomeMessage("ITACREPAR-MNU-102504");

    // 共通HTMLステートメントパーツ
    require_once ( $g['root_dir_path'] . "/libs/webcommonlibs/web_parts_html_statement.php");

    // browse系共通ロジックパーツ02
    require_once ( $root_dir_path . "/libs/webcommonlibs/web_parts_for_browse_02.php");
    

    //----JS-MSGテンプレートのリスト作成
    $aryImportFilePath = array();
    $aryImportFilePath[] = $g['objMTS']->getTemplateFilePath("ITAWDCC","STD","_js");
    $aryImportFilePath[] = $g['objMTS']->getTemplateFilePath("ITACREPAR","STD","_js");

    $strTemplateBody = getJscriptMessageTemplate($aryImportFilePath,$g['objMTS']);
    
    //JS-MSGテンプレートのリスト作成----

    print 
<<< EOD
    <!-------------------------------- ユーザ・コンテンツ情報 -------------------------------->
    <div id="privilege" style="display:none" class="text">{$privilege}</div>
    <div id="sysJSCmdText01" style="display:none" class="text">{$strCmdWordAreaOpen}</div>
    <div id="sysJSCmdText02" style="display:none" class="text">{$strCmdWordAreaClose}</div>
    <div id="messageTemplate" style="display:none" class="text">{$strTemplateBody}</div>
    <!-------------------------------- ユーザ・コンテンツ情報 -------------------------------->
EOD;

    //-- サイト個別PHP要素、ここから--
    
    // Editorに必要なファイルのタイムスタンプを取得
    $timeStamp_common_editor_css = filemtime("$root_dir_path/webroot/common/css/common_editor.css");
    $timeStamp_menu_editor_css = filemtime("$root_dir_path/webroot/menus/systems/2100160011/menu_editor.css");
    
    $timeStamp_00_javascript_js=filemtime("$root_dir_path/webroot/menus/systems/{$g['page_dir']}/00_javascript.js");
    $timeStamp_common_editor_func_js = filemtime("$root_dir_path/webroot/common/javascripts/common_editor_func.js");
    $timeStamp_menu_editor_js = filemtime("$root_dir_path/webroot/menus/systems/2100160011/menu_editor.js");
    
    // メニューID
    $loadMenuID = '';
    $itaEditorMode = 'new';
    $createManagementMenuID = '';
    if ( isset( $_GET['create_menu_id'] ) ) {
      if ( isset( $_GET['mode'] ) ) {
        $itaEditorMode = $_GET['mode'];
      } else {
        $itaEditorMode = 'view';
      }
      $loadMenuID = $_GET['create_menu_id'];
    };
    if ( isset( $_GET['create_management_menu_id'] ) ) {
      $createManagementMenuID = $_GET['create_management_menu_id'];
    };
    print
<<< EOD

<link rel="stylesheet" type="text/css" href="{$scheme_n_authority}/common/css/common_editor.css?{$timeStamp_common_editor_css}">
<link rel="stylesheet" type="text/css" href="{$scheme_n_authority}/menus/systems/2100160011/menu_editor.css?{$timeStamp_menu_editor_css}">

<script type="text/javascript" src="{$scheme_n_authority}/default/menu/02_access.php?client=all&no={$g['page_dir']}"></script>
<script type="text/javascript" src="{$scheme_n_authority}/default/menu/02_access.php?stub=all&no={$g['page_dir']}"></script>

<script type="text/javascript" src="{$scheme_n_authority}/common/javascripts/common_editor_func.js?{$timeStamp_common_editor_func_js}"></script>
<script type="text/javascript" src="{$scheme_n_authority}/menus/systems/2100160011/menu_editor.js?{$timeStamp_menu_editor_js}"></script>

<script type="text/javascript" src="{$scheme_n_authority}/menus/systems/{$g['page_dir']}/00_javascript.js?{$timeStamp_00_javascript_js}"></script>

<div id="menu-editor" class="load-editor" data-editor-mode="{$itaEditorMode}" data-load-menu-id="{$loadMenuID}">
        
  <div id="menu-editor-header">
EOD;
    if ( $itaEditorMode !== 'view') {
    print
<<< EOD
    <div class="menu-editor-menu">
      <ul class="menu-editor-menu-ul">
        <li class="menu-editor-menu-li"><button class="menu-editor-menu-button" data-menu-button="newColumn">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104201")}</button></li>
        <li class="menu-editor-menu-li"><button class="menu-editor-menu-button" data-menu-button="newColumnGroup">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104202")}</button></li>
        <li class="menu-editor-menu-li"><button class="menu-editor-menu-button" data-menu-button="newColumnRepeat">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104203")}</button></li>
      </ul>
      <ul class="menu-editor-menu-ul">
        <li class="menu-editor-menu-li"><button id="button-undo" class="menu-editor-menu-button" data-menu-button="undo">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104204")}</button></li>
        <li class="menu-editor-menu-li"><button id="button-redo" class="menu-editor-menu-button" data-menu-button="redo">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104205")}</button></li>
      </ul>
    </div>
EOD;
    }
    print
<<< EOD
  </div>

  <div id="menu-editor-main">

    <div id="menu-editor-body">

      <div id="menu-editor-edit" class="menu-editor-block">
        <div class="menu-editor-block-inner">
          <div class="menu-table-wrapper">
            <div class="menu-table">
            </div>
          </div> 
        </div>
        <div id="column-resize"></div>
      </div>

      <div id="menu-editor-row-resize"></div>

      <div id="menu-editor-info" class="menu-editor-block">
        <div class="menu-editor-block-inner">

          <div class="editor-tab">
            <div class="editor-tab-menu">
              <ul class="editor-tab-menu-list">
                <li class="editor-tab-menu-list-item" data-tab="menu-editor-preview">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104206")}</li>
                <li class="editor-tab-menu-list-item" data-tab="menu-editor-log">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104207")}</li>
              </ul>
            </div>
            <div class="editor-tab-contents">

              <div id="menu-editor-preview" class="editor-tab-body">
                <h2><div class="midashi_class">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104208")}</div></h2>
                <div class="text">
                  <div class="itaTable tableSticky">
                    <div class="itaTableBody">
                      <div class="tableScroll">
                        <table>
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div id="menu-editor-log" class="editor-tab-body">
                <div class="editor-log">
                  <table class="editor-log-table">
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>                  

            </div>
          </div>

        </div>
      </div>

    </div>
EOD;

    if ( $itaEditorMode === 'view') {
    print
<<< EOD
<div id="panel-container">
  <div id="property" data-menu-type="" data-host-type="" data-vertical-menu="" class="editor-tab">
    <div class="editor-tab-menu">
      <ul class="editor-tab-menu-list">
        <li class="editor-tab-menu-list-item" data-tab="menu-info">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104209")}</li>
      </ul>
    </div>
    <div class="editor-tab-contents">

      <div id="menu-info" class="editor-tab-body">

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104210")}</div>
            <table class="property-table">
              <tbody>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104211")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-id" class="property-span">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104212")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-name" class="property-span"></span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104213")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-type" class="property-span"></span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104214")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-order" class="property-span"></span></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104215")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-use" class="property-span"></span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104216")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-last-modified" class="property-span">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104217")}</th>
                  <td class="property-td" colspan="3"><span id="create-last-update-user" class="property-span">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="menu-group" class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104218")}</div>
            <table class="property-table">
              <tbody>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104219")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-host" type="text" class="property-span"></span></td>
                </tr>
                <tr class="host-group">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104220")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-host-group" type="text" class="property-span"></span></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104221")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-reference" type="text" class="property-span"></span></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104222")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-vertical" type="text" class="property-span"></span></td>
                </tr>
                <tr class="data-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104223")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-data-sheet" type="text" class="property-span"></span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104224")}</div>
            <span id="create-menu-explanation" type="text" class="property-span"></span>
          </div>

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104225")}</div>
            <span id="create-menu-note" type="text" class="property-span"></span>
          </div>

      </div>
    </div>
  </div>
</div>
EOD;
    } else {
    print
<<< EOD
<div id="panel-container">
  <div id="property" data-menu-type="1" data-host-type="1" data-vertical-menu="false" class="editor-tab">
    <div class="editor-tab-menu">
      <ul class="editor-tab-menu-list">
        <li class="editor-tab-menu-list-item" data-tab="menu-info">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104209")}</li>
      </ul>
    </div>
    <div class="editor-tab-contents">

      <div id="menu-info" class="editor-tab-body">

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104210")}</div>
            <table class="property-table">
              <tbody>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104211")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-id" class="property-span" data-value="">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104212")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><input id="create-menu-name" class="property-text" type="text"></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104213")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3">
                    <select id="create-menu-type" class="property-select">
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104214")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><input id="create-menu-order" class="property-number" type="number"></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104215")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3">
                    <select id="create-menu-use" class="property-select">
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104216")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-last-modified" class="property-span" data-value="">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
                <tr>
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104217")}</th>
                  <td class="property-td" colspan="3"><span id="create-last-update-user" class="property-span" data-value="">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104233")}</span></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="menu-group" class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104218")}</div>
            <table class="property-table">
              <tbody>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104219")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><span id="create-menu-host" type="text" class="property-span" data-id="" data-value=""></span></td>
                </tr>
                <tr class="host-group">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104220")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><span id="create-menu-host-group" type="text" class="property-span" data-id="" data-value=""></span></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104221")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><span id="create-menu-reference" type="text" class="property-span" data-id="" data-value=""></span></td>
                </tr>
                <tr class="parameter-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104222")}</th>
                  <td class="property-td" colspan="3"><span id="create-menu-vertical" type="text" class="property-span" data-id="" data-value=""></span></td>
                </tr>
                <tr class="data-sheet">
                  <th class="property-th">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104223")}<span class="input_required">*</span> :</th>
                  <td class="property-td" colspan="3"><span id="create-menu-data-sheet" type="text" class="property-span" data-id="" data-value=""></span></td>
                </tr>
              </tbody>
            </table>
            <ul class="property-button-group">
              <li><button id="create-menu-group-select" class="property-button">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104218")}</button></li>
            </ul>
          </div>

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104224")}</div>
            <textarea id="create-menu-explanation" class="property-textarea" spellcheck="false"></textarea>
          </div>

          <div class="property-group">
            <div class="property-group-title">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104225")}</div>
            <textarea id="create-menu-note" class="property-textarea" spellcheck="false"></textarea>
          </div>

          <p class="note">※<span class="input_required">*</span>{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104235")}</p>

      </div>
    </div>
  </div>
</div>
EOD;
    }

    print
<<< EOD
    </div>
    <div id="menu-editor-footer">
      <div class="menu-editor-menu">
EOD;
    if ( $itaEditorMode === 'new' || $itaEditorMode === 'diversion') {
    print
<<< EOD
        <ul class="menu-editor-menu-ul">
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button positive" data-menu-button="registration" onclick=>{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104226")}</button></li>
        </ul>
EOD;
    } else if ( $itaEditorMode === 'view') {
    print
<<< EOD
        <ul class="menu-editor-menu-ul">
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button positive" data-menu-button="edit">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104227")}</button></li>
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button positive" data-menu-button="diversion">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104228")}</button></li>
EOD;
      if ( $createManagementMenuID !== '' ) {
        print
<<< EOD
          <li class="menu-editor-menu-li">
            <form method="POST" action="/default/menu/01_browse.php?no=2100160004">
              <input type="hidden" id="start_no" name="start_no" value="{$createManagementMenuID}">
              <input type="hidden" id="end_no" name="end_no" value="{$createManagementMenuID}">
              <button type="submit" class="menu-editor-menu-button positive" data-menu-button="management">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104229")}</button>
            </form>
          </li>
        </ul>
EOD;
      }
    } else if ( $itaEditorMode === 'edit') {
    print
<<< EOD
        <ul class="menu-editor-menu-ul">
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button positive" data-menu-button="update">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104226")}</button></li>
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button negative" data-menu-button="reload">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104230")}</button></li>
          <li class="menu-editor-menu-li"><button class="menu-editor-menu-button negative" data-menu-button="cancel">{$g['objMTS']->getSomeMessage("ITACREPAR-MNU-104231")}</button></li>
        </ul>
EOD;
    }
    print
<<< EOD
      </div>
    </div>
  </div>
</div>

EOD;
    //-- サイト個別PHP要素、ここまで--


    //  共通HTMLフッタパーツ
    require_once ( $root_dir_path . "/libs/webcommonlibs/web_parts_html_footer.php");

?>
