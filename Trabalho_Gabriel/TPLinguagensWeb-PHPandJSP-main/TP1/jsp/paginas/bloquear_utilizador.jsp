<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%

	// Verificar se o utilizador está autenticado e se é administrador
	if (session.getAttribute("perfil") == null || !session.getAttribute("perfil").equals("admin")) {

			response.sendRedirect("index.jsp");

		
	} else {
		String id_utilizador = request.getParameter("id");
		String email_utilizador = request.getParameter("e_mail");
		String user_name = request.getParameter("user_name");

		
		PreparedStatement ps = null;

		String sql = "UPDATE utilizadores SET autenticado = 0 WHERE id_utilizador = ?";
		ps = conn.prepareStatement(sql);
		ps.setString(1, id_utilizador);
		int rowsAffected = ps.executeUpdate();

		if (rowsAffected > 0) {
			out.println("<h4>Utilizador com id=" + id_utilizador + "<br>user_name=" + user_name + " <br>e-mail=" + email_utilizador + "</h4>foi bloqueado!<br>");
			out.println("<a href='menu_admin.jsp'>Voltar para página admin</a>");
			response.setHeader("Refresh", "3; URL=menu_admin.jsp");
		}
	}
%>