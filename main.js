$(document).ready(function() {
   (function(){ 
      $('#list').DynamicList({
         addOnly: true,
         triggerAddElement: '#ctrl'
      });
      
      $('#form').SimpleFileUpload();
      $('#form').bind('submit', function() {
         
         var files = $('input[type="file"]');
         
         var js = $.grep(files, function(item){
               return /\.js|\.JS/.test($(item).val());
         });
         
         var css = $.grep(files, function(item){
               return /\.css|\.CSS/.test($(item).val());
         });
         
         if(js.length > 0 && css.length > 0) {
            alert('Fehler: JavaScript- und CSS-Dateien können nicht gleichzeitig verarbeitet werden!');
            return false;
         }
         
         var empty = $.grep(files, function(item){
              return $.trim($(item).val()) == ""; 
         });

         if(js.length + empty.length != files.length && css.length + empty.length != files.length) {
            alert('Fehler: Ungültige Eingabe\nDiese Anwendung unterstützt nur JavaScript- und CSS-Dateien');
            return false;
         }
         
         if(empty.length < files.length) {
            
            var filename = $('input[name="intermediate"]');         
            if($.trim(filename.val()) != '') {
               $('input[name="output"]').val( encodeURI( filename.val() ) );
               return true;
            }
            else {
               alert('Bitte einen Namen für die neue Datei eingeben!');
               filename.get(0).focus();
               return false;
            }
         }
         else {
            $('input[type="file"]:first').trigger('click');
            return false;
         }
      });
   })();
});