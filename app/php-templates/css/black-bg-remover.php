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
  font-family: 'Open Sans',
    sans-serif;
}

.form-select select:focus {
  background: #fafcfb;
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
}

.form-select select::placeholder {
  /* color: black; */
  padding-left: 0px;
  font-family: 'Open Sans',
    sans-serif;
}

.form_select-group .form_input-group .form_textarea-group {
  margin-bottom: 1rem;
  font-family: 'Open Sans',
    sans-serif;
}
.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    appearance: none;
    border-radius: .25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out
}

@media (prefers-reduced-motion: reduce) {
    .form-control {
        transition: none
    }
}

.form-control[type="file"] {
    overflow: hidden
}

.form-control[type="file"]:not(:disabled):not([readonly]) {
    cursor: pointer
}

.form-control:focus {
    color: #212529;
    background-color: #fff;
    border-color: #81cbb8;
    outline: 0;
    box-shadow: 0 0 0 .25rem rgba(2, 150, 112, 0.25)!important;
}

.form-control::-webkit-date-and-time-value {
    height: 1.5em
}

.form-control::placeholder {
    color: #6c757d;
    opacity: 1
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
    min-height: calc(1.5em + .5rem + 2px);
    padding: .25rem .5rem;
    font-size: .875rem;
    border-radius: .2rem
}

.form-control-sm::file-selector-button {
    padding: .25rem .5rem;
    margin: -.25rem -.5rem;
    margin-inline-end: .5rem
}

.form-control-sm::-webkit-file-upload-button {
    padding: .25rem .5rem;
    margin: -.25rem -.5rem;
    margin-inline-end: .5rem
}

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
		font-family: 'Open Sans',
				sans-serif;		
}
.form-select select:focus {
	background: #fafcfb;
	font-family: 'Open Sans', sans-serif;
	font-size: 16px;
}

.form-select select::placeholder {
	/* color: black; */
	padding-left: 0px;
	font-family:'Open Sans',
		sans-serif;	
}

.form_select-group .form_input-group .form_textarea-group{
	margin-bottom: 1rem;
	font-family: 'Open Sans',
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

</style>