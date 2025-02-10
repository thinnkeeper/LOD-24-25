<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%

	// verifica se o utilizador esta logado e se o perfil é admin
	// Apenas o admin pode excluir utilizadores
	if (session.getAttribute("perfil") == null || !session.getAttribute("perfil").equals("admin")) {
		response.sendRedirect("index.jsp");
	} else {
		String id_utilizador = request.getParameter("id");
	String email_utilizador = request.getParameter("e_mail");
	String user_name = request.getParameter("user_name");
	
	out.println("<h4>TEM A CERTEZA QUE QUER: Excluir o utilizador <span style='color: red; text-transform: uppercase;'>" + user_name + "</span> da base de dados?</h4>");
	out.println("<a href='delete_utilizador.jsp?id=" + id_utilizador + "&e_mail=" + email_utilizador + "&user_name=" + user_name + "'>SIM!</a><br>");
	out.println("<a href='menu_admin.jsp'>NÃO!</a>");	
	}
	
%>