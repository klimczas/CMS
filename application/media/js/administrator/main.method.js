$(function() {
      
	$(".allModuleLists").toggle(); //odniesienia do poszczegolnych klas
    $(".allModelLists").toggle();
	
});
//funkcje do otwierania i zamykanai listy  (pokaz schowaj liste)
function toggleModuleList(id)
{
	$("#moduleList"+id).toggle();
}

function toggleModelList(id)
{
	$("#modelList"+id).toggle();
}