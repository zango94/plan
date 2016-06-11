/**
 * @author S³awomir Kok³owski {@link http://www.kurshtml.edu.pl}
 * @copyright NIE usuwaj tego komentarza! (Do NOT remove this comment!)
 */

Date.prototype.date = function(format)
{
	for (var i = 0, c = '', returner = '', formats = new Object(); i < format.length; i++)
	{
		c = format.charAt(i);
		if (c == '\\' && i + 1 < format.length) returner += format.charAt(++i);
		else if (typeof formats[c] != 'undefined') returner += formats[c];
		else
		{
			switch (c)
			{
				case 'a':
					formats[c] = this.getHours() < 12 ? 'przed po³udniem' : 'po po³udniu';
					break;
				case 'd':
					var day = this.getDate();
					formats[c] = (day < 10 ? '0' : '') + day;
					break;
				case 'D':
					var days = new Array('Nie', 'Pon', 'Wto', 'Œro', 'Czw', 'Pi¹', 'Sob');
					formats[c] = days[this.getDay()];
					break;
				case 'E':
					var month = new Array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'wrzeœnia', 'paŸdziernika', 'listopada', 'grudnia');
					formats[c] = month[this.getMonth()];
					break;
				case 'F':
					var month = new Array('Styczeñ', 'Luty', 'Marzec', 'Kwiecieñ', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpieñ', 'Wrzesieñ', 'PaŸdziernik', 'Listopad', 'Grudzieñ');
					formats[c] = month[this.getMonth()];
					break;
				case 'g':
					formats[c] = (this.getHours() - 1) % 12 + 1;
					break;
				case 'G':
					formats[c] = this.getHours();
					break;
				case 'h':
					var hour = (this.getHours() - 1) % 12 + 1;
					formats[c] = (hour < 10 ? '0' : '') + hour;
					break;
				case 'H':
					var hour = this.getHours();
					formats[c] = (hour < 10 ? '0' : '') + hour;
					break;
				case 'i':
					var minute = this.getMinutes();
					formats[c] = (minute < 10 ? '0' : '') + minute;
					break;
				case 'j':
					formats[c] = this.getDate();
					break;
				case 'l':
					var days = new Array('Niedziela', 'Poniedzia³ek', 'Wtorek', 'Œroda', 'Czwartek', 'Pi¹tek', 'Sobota');
					formats[c] = days[this.getDay()];
					break;
				case 'L':
					formats[c] = this.getFullYear() % 400 && (this.getFullYear() % 4 || !(this.getFullYear() % 100)) ? 0 : 1;
					break;
				case 'm':
					var month = this.getMonth() + 1;
					formats[c] = (month < 10 ? '0' : '') + month;
					break;
				case 'M':
					var month = new Array('Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sieñ', 'Wrz', 'PaŸ', 'Lis', 'Gru');
					formats[c] = month[this.getMonth()];
					break;
				case 'n':
					formats[c] = this.getMonth() + 1;
					break;
				case 'O':
					var O = -this.getTimezoneOffset() / 60;
					if (O < 0)
					{
						var sign = '-';
						O = -O;
					}
					else sign = '+';
					formats[c] = sign + (O < 10 ? '0' : '') + O + '00';
					break;
				case 'r':
					formats[c] = this.date('D, d M Y H:i:s O');
					break;
				case 's':
					var second = this.getSeconds();
					formats[c] = (second < 10 ? '0' : '') + second;
					break;
				case 'S':
					if (this.getDate().toString().search(/(^|[02-9])1$/) != -1) formats[c] = '-wszy';
					else if (this.getDate().toString().search(/(^|[02-9])2$/) != -1) formats[c] = '-gi';
					else if (this.getDate().toString().search(/(^|[02-9])3$/) != -1) formats[c] = '-ci';
					else if (this.getDate().toString().search(/(^|[02-9])[78]$/) != -1) formats[c] = '-my';
					else formats[c] = '-ty';
					break;
				case 't':
					var months = new Array(31, this.getFullYear() % 400 && (this.getFullYear() % 4 || !(this.getFullYear() % 100)) ? 28 : 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
					formats[c] = months[this.getMonth()];
					break;
				case 'U':
					formats[c] = Date.parse(this) / 1000;
					break;
				case 'w':
					formats[c] = this.getDay();
					break;
				case 'W':
					var day = this.getDay() - 1;
					if (day == -1) day = 6;
					formats[c] = Math.round((this.date('z') - day + 6) / 7);
					if (formats[c] == 0)
					{
						var date = new Date(this.getFullYear() - 1, 11, 31, 23, 59, 59);
						day = date.getDay() - 1;
						if (day == -1) day = 6;
						formats[c] = Math.round((date.date('z') - day + 6) / 7);
					}
					else
					{
						var date = new Date(this.getFullYear(), 11, 31, 23, 59, 59);
						day = date.getDay() - 1;
						if (day == -1) day = 6;
						if (day < 3 && this.date('z') >= date.date('z') - day) formats[c] = 1;
					}
					break;
				case 'Y':
					formats[c] = this.getFullYear();
					break;
				case 'y':
					formats[c] = this.getFullYear().toString().substring(2);
					break;
				case 'z':
					var months = new Array(31, this.getFullYear() % 400 && (this.getFullYear() % 4 || !(this.getFullYear() % 100)) ? 28 : 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
					formats[c] = this.getDate();
					for (var j = 0, month = this.getMonth(); j < month; j++) formats[c] += months[j];
					break;
				case 'Z':
					formats[c] = -this.getTimezoneOffset() * 60;
					break;
				default:
					formats[c] = c;
					break;
			}
			returner += formats[c];
		}
	}
	
	return returner;
}