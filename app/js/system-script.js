/**
 *  Web Service
 */
//  const axios = require('axios');
 // const jQuery = $;
 
 $ = (typeof $ !== 'undefined') ? $ : {};
 $.SystemScript = (typeof $.SystemScript !== 'undefined') ? $.SystemScript : {};
 
 $.SystemScript = (function() {
     let __executeGet = function (path) {
         let dfd = $.Deferred();
 
         axios.get(path)
           .then(function (response) {
             dfd.resolve(response);
           })
           .catch(function (error) {
             dfd.resolve({
                 status : 'ERROR',
                 message : error
             });
 
           })
         return dfd.promise();
     };

     let __executeDelete = function (path) {
 
        let dfd = $.Deferred();

        axios.delete(path)
          .then(function (response) {
            dfd.resolve(response);
          })
          .catch(function (error) {
            dfd.resolve({
                status : 'ERROR',
                message : error
            });

          })
        return dfd.promise();
    };
     let __executePost = function(path, jsonObj) {
         path = path;
         let d = $.Deferred();
 
         axios.post(path, jsonObj)
         .then(function (response) {
             d.resolve(response)
         })
         .catch(function (error) {
             d.resolve({
                 status : 'ERROR',
                 message : error
             });
             console.log('ee')
 
         });
 
         return d.promise();
     };
 
 
     
 
         //action (String)
     let __swalAlertMessage = function (head, mes, action) {
             let d = $.Deferred();
             let response = true;
 
             swal(head,mes,action)
 
             d.resolve(response)
             return d.promise();
     }
     let __swalConfirmMessage = function(head, mes, action) {
         let d = $.Deferred();
         swal({
             title: head,
             text: mes,
             type: action,
             confirmButtonText: "Yes",
             showCancelButton: true
         })
         .then((result) => {
             let response = false;
 
             if (result.value) {
                 response = true;
             } else {
                 response = false;
 
             }
             d.resolve(response)
         })
         return d.promise();
     }
 
     return {
         executePost : __executePost,
         executeGet : __executeGet,
         executeDelete: __executeDelete,
         swalAlertMessage: __swalAlertMessage,
         swalConfirmMessage: __swalConfirmMessage,
     };
 }());