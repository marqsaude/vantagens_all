

	
	function printView(){
		
		$(document).ready(function() {
		
		window.print();
		window.history.back();
		return false;
		//window.location.href = 'javascript:self.print()';
		});
	}
	
printView();