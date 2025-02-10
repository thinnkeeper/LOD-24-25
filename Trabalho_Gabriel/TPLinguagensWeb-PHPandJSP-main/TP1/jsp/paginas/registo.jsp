<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%

	if (request.getParameter("nome") == null || request.getParameter("ultimo_nome") == null || request.getParameter("e_mail") == null || request.getParameter("user_name") == null || request.getParameter("password") == null || request.getParameter("perfil") == null) {
		response.sendRedirect("index.jsp");
	} else {

	
		String nome = request.getParameter("nome");
		String ultimo_nome = request.getParameter("ultimo_nome");
		String e_mail = request.getParameter("e_mail");
		String user_name = request.getParameter("user_name");
		String password = request.getParameter("password");
		String perfil = request.getParameter("perfil");


		PreparedStatement ps = null;
		ResultSet rs = null;



		String verificar_utilizador = "SELECT * FROM utilizadores WHERE user_name = ? OR e_mail = ?";

		ps = conn.prepareStatement(verificar_utilizador);
		ps.setString(1, user_name);
		ps.setString(2, e_mail);
		rs = ps.executeQuery();



		if (rs.next()) {
			out.println("<h3>Nome de usuário ou e-mail já utilizados!</h3>");
			response.setHeader("Refresh", "3; URL=index.jsp");
		} else {
			String sql = "INSERT INTO utilizadores (nome, ultimo_nome, e_mail, user_name, password, perfil) VALUES (?,?,?,?,MD5(?),?)";
			PreparedStatement psInsert = conn.prepareStatement(sql);
			psInsert.setString(1, nome);
			psInsert.setString(2, ultimo_nome);
			psInsert.setString(3, e_mail);
			psInsert.setString(4, user_name);
			psInsert.setString(5, password);
			psInsert.setString(6, perfil);

			
			int rowsAffected = psInsert.executeUpdate();
			if (rowsAffected > 0) {
				out.println("<h3>Utilizador " + user_name + " adicionado com sucesso!</h3>");

				if (request.getParameter("isDocente").equals("true"))
				response.setHeader("Refresh", "3; URL=menu_admin.jsp");
				else 
				response.setHeader("Refresh", "3; URL=index.jsp");
			} 
			conn.close();	

			
		}

		ps.close();
		rs.close();
		
	}
			
	
%>