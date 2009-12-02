// JavaScript Document for icons page - loads content into divs in fieldsets on page load

if (isJsEnabled()) {
	addLoadEvent(testme('hello world'));
	var url = "/greenhouse/icons/genre?theme=simple&genre=sustainability&filter="
  addLoadEvent(ajaxpage(url,"sustainabilitydiv"));
  addLoadEvent(ajaxpage("/greenhouse/icons/genre?theme=simple&genre=nature&filter=","naturediv"));
  addLoadEvent(ajaxpage("/greenhouse/icons/genre?theme=simple&genre=culture&filter=","culturediv"));
}

function testme(message) {
	alert(message);
}