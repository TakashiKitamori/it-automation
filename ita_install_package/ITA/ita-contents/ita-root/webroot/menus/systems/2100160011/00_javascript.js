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
//   limitations under the License
//

//////// ----コールバックファンクション ////////
function callback() {}
callback.prototype = {
    /////////////////////
    // callback: 新規登録
    /////////////////////
    registerTable : function(result){
        var ary_result = getArrayBySafeSeparator(result);
        // 正常の場合
        if( ary_result[0] == "000" ){
            var result = JSON.parse(ary_result[2]);
            var id  = result['CREATE_MENU_ID'];
            var num = result['MM_STATUS_ID'];
            var string = getSomeMessage("ITACREPAR_1236");
            var log = string + num;
            menuEditorLog.set('done', log );
            window.alert(log);
            location.href = '/default/menu/01_browse.php?no=2100160011&create_menu_id=' + id + '&create_management_menu_id=' + num;
        }
        // バリデーションエラーの場合
        else if( ary_result[0] == "002" || ary_result[0] == "003"){
            // 二回目以降のバリデエラーの場合に前回表示したエラーログを消す
            menuEditorLog.clear();
            menuEditorLog.set('error', ary_result[2] );
            window.alert(getSomeMessage("ITAWDCC90102"));
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
        // セッション切れの場合
        if( ary_result[0]  == "redirectOrderForHADACClient"){
            window.location.replace(ary_result[2]);
        }
    },
    /////////////////////
    // callback: 更新
    /////////////////////
    updateTable : function(result){
        var ary_result = getArrayBySafeSeparator(result);
        // 正常の場合
        if( ary_result[0] == "000" ){
            var result = JSON.parse(ary_result[2]);
            var id  = result['CREATE_MENU_ID'];
            var num = result['MM_STATUS_ID'];
            var string = getSomeMessage("ITACREPAR_1236");
            var log = string + num; 
            menuEditorLog.set('done', log );
            window.alert(log);
            location.href = '/default/menu/01_browse.php?no=2100160011&create_menu_id=' + id + '&create_management_menu_id=' + num;
        }
        // バリデーションエラーの場合
        else if( ary_result[0] == "002" || ary_result[0] == "003"){
            // 二回目以降のバリデエラーの場合に前回表示したエラーログを消す
            menuEditorLog.clear();
            menuEditorLog.set('error', ary_result[2] );
            window.alert(getSomeMessage("ITAWDCC90102"));
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
        // セッション切れの場合
        if( ary_result[0]  == "redirectOrderForHADACClient"){
            window.location.replace(ary_result[2]);
        }
    },
    /////////////////////
    // callback: 入力方式リスト取得
    /////////////////////
    selectInputMethod: function(result){

        var ary_result = getArrayBySafeSeparator(result);
        
        // 正常の場合
        if( ary_result[0] == "000" ){
            menuEditorArray.selectInputMethod = JSON.parse(ary_result[2]);
            selectParamTarget();
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    },
    /////////////////////
    // callback: 作成対象リスト取得
    /////////////////////
    selectParamTarget : function(result){

        var ary_result = getArrayBySafeSeparator(result);

        // 正常の場合
        if( ary_result[0] == "000" ){
            menuEditorArray.selectParamTarget = JSON.parse(ary_result[2]);
            selectParamPurpose();
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    },
    /////////////////////
    // callback: 用途リスト取得
    /////////////////////
    selectParamPurpose : function(result){

        var ary_result = getArrayBySafeSeparator(result);

        // 正常の場合
        if( ary_result[0] == "000" ){
            menuEditorArray.selectParamPurpose = JSON.parse(ary_result[2]);
            selectMenuGroupList();
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    },
    /////////////////////
    // callback: メニューグループリスト取得
    /////////////////////
    selectMenuGroupList : function(result){
        var ary_result = getArrayBySafeSeparator(result);

        // 正常の場合
        if( ary_result[0] == "000" ){
            menuEditorArray.selectMenuGroupList = JSON.parse(ary_result[2]);
            selectPulldownList();
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    },
    /////////////////////
    // callback: プルダウン選択項目リスト取得
    /////////////////////
    selectPulldownList : function(result){
       var ary_result = getArrayBySafeSeparator(result);

       // 正常の場合
       if( ary_result[0] == "000" ){
           menuEditorArray.selectPulldownList = JSON.parse(ary_result[2]);
           if ( menuEditorTargetID === '') {
              menuEditor( menuEditorMode, menuEditorArray );
           } else {
              selectMenuInfo( menuEditorTargetID );
           }
       }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    },
    /////////////////////
    // callback: メニュー作成情報関連データ取得
    /////////////////////
    selectMenuInfo : function(result){
        var ary_result = getArrayBySafeSeparator(result);
        // 正常の場合
        if( ary_result[0] == "000" ){
            menuEditorArray.selectMenuInfo = JSON.parse(ary_result[2]);
            menuEditor( menuEditorMode, menuEditorArray );
        }
        // システムエラーの場合
        else{
            window.alert(getSomeMessage("ITAWDCC90101"));
        }
    }
}


var proxy = new Db_Access(new callback());
var filter_on = false;

window.onload = function(){
}

/////////////////////
// 新規登録
/////////////////////
function registerTable(menuData){
    proxy.registerTable(menuData);
}

/////////////////////
// 更新
/////////////////////
function updateTable(menuData){
    proxy.updateTable(menuData);
}

/////////////////////
// 入力方式リスト取得
/////////////////////
function selectInputMethod(){
    proxy.selectInputMethod();
}

/////////////////////
// 作成対象リスト取得
/////////////////////
function selectParamTarget(){
    proxy.selectParamTarget();
}

/////////////////////
// 用途リスト取得
/////////////////////
function selectParamPurpose(){
    proxy.selectParamPurpose();
}

/////////////////////
// メニューグループリスト取得
/////////////////////
function selectMenuGroupList(){
    proxy.selectMenuGroupList();
}

/////////////////////
// プルダウン選択項目リスト取得
/////////////////////
function selectPulldownList(){
    proxy.selectPulldownList();
}

/////////////////////
// メニュー作成情報関連データ取得
/////////////////////
function selectMenuInfo(createMenuId){
    proxy.selectMenuInfo(createMenuId);
}


$( function(){

    menuEditorMode = $('#menu-editor').attr('data-editor-mode');
    menuEditorTargetID = $('#menu-editor').attr('data-load-menu-id');
    
    // 各種リストを順次読み込む
    selectInputMethod();

});