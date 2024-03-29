
<style>

    <!-- Progress with steps -->

    ol.progtrckr {
        margin: 0;
        padding: 0;
        list-style-type none;
    }

    ol.progtrckr li {
        display: inline-block;
        text-align: center;
        line-height: 3em;
    }

    ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
    ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
    ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
    ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
    ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
    ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
    ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
    ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

    ol.progtrckr li.progtrckr-done {
        color: black;
        border-bottom: 4px solid yellowgreen;
    }
    ol.progtrckr li.progtrckr-todo {
        color: silver; 
        border-bottom: 4px solid silver;
    }

    ol.progtrckr li:after {
        content: "\00a0\00a0";
    }
    ol.progtrckr li:before {
        position: relative;
        bottom: -2.5em;
        float: left;
        left: 50%;
        line-height: 1em;
    }
    ol.progtrckr li.progtrckr-done:before {
        content: "\2713";
        color: white;
        background-color: yellowgreen;
        height: 1.2em;
        width: 1.2em;
        line-height: 1.2em;
        border: none;
        border-radius: 1.2em;
    }
    ol.progtrckr li.progtrckr-todo:before {
        content: "\039F";
        color: silver;
        background-color: white;
        font-size: 1.5em;
        bottom: -1.6em;
    }

</style>

<?php

switch($this->input->get('act')){

default:
?>
<table width="100%">
	<tr>
	<td><a href=?act=detail&id=1>Form Cuti No.1</a></td>
	<td>
			<ol class="progtrckr" data-progtrckr-steps="4">
    			<li class="progtrckr-done">Atasan Langsung</li>
    			<li class="progtrckr-done">Atasan Lebih Tinggi</li>
    			<li class="progtrckr-todo">Staf HRD</li>
    			<li class="progtrckr-todo">Ka Div HRD</li>    
			</ol>
	</td></tr>
	<tr>
		<td><a href=?act=detail&id=2>Form Cuti No.2</a></td>
		<td>
			<ol class="progtrckr" data-progtrckr-steps="4">
    			<li class="progtrckr-done">Atasan Langsung</li>
    			<li class="progtrckr-done">Atasan Lebih Tinggi</li>
    			<li class="progtrckr-done">Staf HRD</li>
    			<li class="progtrckr-todo">Ka Div HRD</li>   
			</ol>
	</td></tr>
</table>

<?php
break;

case"bSearch":

break;
}
?>  