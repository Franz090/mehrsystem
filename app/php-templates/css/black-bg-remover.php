<!-- black bg remover  -->
<!-- <style>
   * {
      background-color:#FFF !important; 
   }
</style> -->
<style>
.form_select_focus:focus,
.form_select_focus:invalid {
  border: 1px solid #ebecf0;
  box-shadow: 0 0 5px #60e9d5;
  -webkit-transition: all 0.30s ease-in-out;
  -moz-transition: all 0.30s ease-in-out;
  -ms-transition: all 0.30s ease-in-out;
  -o-transition: all 0.30s ease-in-out;

}

.form_select select {
  width: 100%;
  height: 45px;
  padding-left: 11px;
  margin-bottom: 20px;
  box-sizing: border-box;
  box-shadow: none;
  border: 1px solid #00000020;
  border-radius: 10px;
  outline: none;
  background: #FBFDFC;
  transition: -1s ease-in;
  font-family: 'Roboto',
    sans-serif;
}

.form-select select:focus {
  background: #fafcfb;
  font-family: 'Roboto', sans-serif;
  font-size: 16px;
}

.form-select select::placeholder {
  /* color: black; */
  padding-left: 0px;
  font-family: 'Roboto',
    sans-serif;
}

.form_select-group .form_input-group .form_textarea-group {
  margin-bottom: 1rem;
  font-family: 'Roboto',
    sans-serif;
}


.form-control {
    display: block;
    width: 100%;
    padding: .375rem 2.25rem .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057!important;
    background-color: #f0eded!important;
    background-clip: padding-box;
    border:  none!important;
    border-radius: .18rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out!important;
}


@media (prefers-reduced-motion: reduce) {
    .form-control {
        transition: none!important;
    }
}

.form-control[type="file"] {
    overflow: hidden!important;
    
}

.form-control[type="file"]:not(:disabled):not([readonly]) {
    cursor: pointer;
}

.form-control:focus {
    color: #495158!important;
    background-color: #e9e9eb!important;
    box-shadow: none!important;
 
    
    /* box-shadow: 0 0 0 .25rem rgba(2, 150, 112, 0.25)!important; */
}

.form-control::-webkit-date-and-time-value {
    height: 1.5em
}

.form-control::placeholder {
    color: #586967!important;
    opacity: 1;
   
}

.form-control:disabled,
.form-control[readonly] {
    background-color: #e9ecef;
    opacity: 1
}

.form-control::file-selector-button {
    padding: .375rem .75rem;
    margin: -.375rem -.75rem;
    margin-inline-end: .75rem;
    color: #212529;
    background-color: #e9ecef;
    pointer-events: none;
    border-color: inherit;
    border-style: solid;
    border-width: 0;
    border-inline-end-width: 1px;
    border-radius: 0;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
}


@media (prefers-reduced-motion: reduce) {
    .form-control::file-selector-button {
        transition: none
    }
}

.form-control:hover:not(:disabled):not([readonly])::file-selector-button {
    background-color: #dde0e3
}

.form-control::-webkit-file-upload-button {
    padding: .375rem .75rem!important;
    margin: -.375rem -.75rem!important;
    margin-inline-end: .75rem!important;
    color: #212529!important;
    background-color: #e9ecef!important;
    pointer-events: none!important;
    border-color: inherit!important;
    border-style: solid!important;
    border-width: 0!important;
    
    border-inline-end-width: 1px!important;
    border-radius: 0!important;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out!important;
}

@media (prefers-reduced-motion: reduce) {
    .form-control::-webkit-file-upload-button {
        transition: none!important;
    }
}

.form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
    background-color: #dde0e3!important;
}

.form-control-plaintext {
    display: block!important;
    width: 100%!important;
    padding: .375rem 0!important;
    margin-bottom: 0!important;
    line-height: 1.5!important;
    color: #212529!important;
    background-color: transparent!important;
    border: solid transparent!important;
    border-width: 1px 0!important;
}

.form-control-plaintext.form-control-sm,
.form-control-plaintext.form-control-lg {
    padding-right: 0;
    padding-left: 0
}

.form-control-sm {
    padding-top: .28rem;
        padding-bottom: .28rem;
        padding-left: .10rem;
        padding-right: .15rem!important;
        font-size: .875rem;
}

/* .form-control-sm::file-selector-button {
    padding: .25rem .5rem;
    margin: -.25rem -.5rem;
    margin-inline-end: .5rem
}

.form-control-sm::-webkit-file-upload-button {
    padding: .25rem .5rem;
    margin: -.25rem -.5rem;
    margin-inline-end: .5rem
} */

.form-control-lg {
    min-height: calc(.5em + .3rem + 1px)!important;
    padding: .3rem .3rem!important;
    font-size: 1.25rem!important;
   
    border-radius: .50rem!important;
}

.form-control-lg::file-selector-button {
    padding: .5rem 1rem!important;
    margin: -.5rem -1rem!important;
    margin-inline-end: 1rem!important;
}

.form-control-lg::-webkit-file-upload-button {
    padding: .5rem 1rem!important;
    margin: -.5rem -1rem!important;
    margin-inline-end: 1rem!important;
}
select {
  color: #757575;
}

select:focus {
  color: var(--text-primary-color);
}
.form_select_focus:focus, .form_select_focus:invalid {
    border: 1px solid #ebecf0;
	box-shadow: 0 0 5px #60e9d5;
	-webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
	-ms-transition: all 0.30s ease-in-out;
   -o-transition: all 0.30s ease-in-out;
   
}

.form_select select{
	    width: 100%!important;
		height: 45px!important;
		padding-left:11px;
		margin-bottom: 20px;
		box-sizing: border-box;
		box-shadow: none;
		border: 1px solid #00000020;
		border-radius: 10px;
		outline: none;
		background: #FBFDFC;
		transition: -1s ease-in;
		font-family: 'Roboto',
				sans-serif;		
}
.form-select select:focus {
	background: #fafcfb;
	font-family: 'Roboto', sans-serif;
	font-size: 16px;
}

.form-select select::placeholder {
	/* color: black; */
	padding-left: 0px;
	font-family:'Roboto',
		sans-serif;	
}

.form_select-group .form_input-group .form_textarea-group{
	margin-bottom: 1rem;
	font-family: 'Roboto',
			sans-serif;		
}
select{
	color: #757575;
}
select:focus{
	color: var(--text-primary-color);
}
   select:required:invalid {
        color: #666;
      }
      option[value=""][disabled] {
        display: none;
      }
      option {
        color: #000;
      }
      /* .option{
        position: relative;
        left: 550px;
      } */
      #selectCenter {
  
 
    padding-left: 16px;
   position: relative;
    
}

.btn-primary {
    color: whitesmoke;
    background-color: #169e7c!important;
    border-color: #029670!important;
    border-radius: 1.5rem!important;
    padding: 3px 16px !important;
}

.btn-primary:hover {
    color: whitesmoke;
    background-color: #28a685!important;
    border-color: #1ba17e!important;
    border-radius: 1.5rem !important;
}

.btn-check:focus+.btn-primary,
.btn-primary:focus {
    color: whitesmoke;
    background-color: #28a685!important;
    border-color: #1ba17e!important;
    box-shadow: none!important;
}

.btn-check:checked+.btn-primary,
.btn-check:active+.btn-primary,
.btn-primary:active,
.btn-primary.active,
.show>.btn-primary.dropdown-toggle {
    color: whitesmoke;
    background-color: #35ab8d!important;
    border-color: #1ba17e!important;
}

.btn-check:checked+.btn-primary:focus,
.btn-check:active+.btn-primary:focus,
.btn-primary:active:focus,
.btn-primary.active:focus,
.show>.btn-primary.dropdown-toggle:focus {
    box-shadow: none!important;
}

.btn-lg+.dropdown-toggle-split,
.btn-group-lg>.btn+.dropdown-toggle-split {
    padding-right: .75rem!important;
    padding-left: .75rem!important;
}
.btn-lg,
.btn-group-lg>.btn {
    padding: .5rem 1rem!important;
    font-size: 1.25rem!important;
   
}

.btn-sm,
.btn-group-sm>.btn {
    padding: .25rem .5rem;
    font-size: .875rem;
    border-radius: .2rem
}

.btn-primary:disabled,
.btn-primary.disabled {
    color: whitesmoke;
    background-color: #029670!important;
    border-color: #029670
}

.btn {
    display: inline-block;
    font-weight: 400;
    font-size: 15px!important;
    font-family: "Roboto",sans-serif;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    border-radius: .25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
}

@media (prefers-reduced-motion: reduce) {
    .btn {
        transition: none
    }
}

.btn:hover {
    color: #212529
}

.btn-check:focus+.btn,
.btn:focus {
    outline: 0;
    box-shadow: 0 0 0 .25rem rgba(2, 150, 112, 0.25)
}

.btn:disabled,
.btn.disabled,
fieldset:disabled .btn {
    pointer-events: none;
    opacity: .65
}
</style>