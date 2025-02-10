<%@ page language="java" %>
<%
	//destroi as variaveis de sessão e vai para a página inicial
	session = request.getSession(false);
	if(session != null){
    	session.invalidate();
		
	}
    response.sendRedirect("index.jsp");
%>


