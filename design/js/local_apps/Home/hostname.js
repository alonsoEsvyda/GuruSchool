function Hostname(){
	var loc = window.location;
	var Route = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length));
	return Route;
}