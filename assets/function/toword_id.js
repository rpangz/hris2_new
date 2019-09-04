// Convert numbers to words
// copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
// permission to use this Javascript on your web page is granted
// provided that all of the code (including this copyright notice) is
// used exactly as shown (you can change the numbering system if you wish)

// American Numbering System
var th = ['','Ribu','Juta', 'Miliar','Triliun'];
// uncomment this line for English Number System
// var th = ['','thousand','million', 'milliard','billion'];

var dg = ['Nol','Satu','Dua','Tiga','Empat', 'Lima','Enam','Tujuh','Delapan','Sembilan']; 
var tn = ['Sepuluh','Sebelas','Dua Belas','Tiga Belas','Empat Belas', 'Lima Belas','Enam Belas','Tujuh Belas', 'Delapan Belas','Sembilan Belas']; 
var tw = ['Dua Puluh','Tiga Puluh','Empat Puluh','Lima Puluh', 'Enam Puluh','Tujuh Puluh','Delapan Puluh','Sembilan Puluh']; 
function toWords(s){s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != parseFloat(s)) return 'not a number'; 
var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; 
var n = s.split(''); 
var str = ''; 
var sk = 0; 
for (var i=0; i < x; i++) {
	if ((x-i)%3==2) {
		if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} 
		else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} 
		else if (n[i]!=0) {str += dg[n[i]] +' '; 
if ((x-i)%3==0) str += 'Ratus ';sk=1;} 
if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} 
if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} 
return str.replace(/\s+/g,' ');}