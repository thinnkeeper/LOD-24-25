<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Docente</title>
</head>
<body>
<%
	String perfil = (String) session.getAttribute("perfil"); 
	PreparedStatement ps = null;
	ResultSet rs = null;

	if (perfil != null && (perfil.equals("docente") || perfil.equals("admin"))) {
		out.println("<a href='logout.jsp'>Logout</a><br>");

		if (perfil.equals("docente")) {
			out.println("<a href='menu_docente.jsp'>Home Page</a><br>");
		} else {
			out.println("<a href='menu_admin.jsp'>Home Page</a><br>");
		}

		String id_curso =  request.getParameter("id_curso");
		out.println("<a href='cancelar_curso.jsp?id_curso=" + id_curso + "'>Cancelar curso?</a>");

		out.println("<h2>Editar curso</h2>");
		String sql_curso = "SELECT * FROM cursos WHERE id_curso = " + id_curso;

		ps = conn.prepareStatement(sql_curso);
		rs = ps.executeQuery();

		String nome_curso = null;
		
		if (rs.next()) {
			int vagas_disponiveis = rs.getInt("vagas_disponiveis");
			int vagas_totais_antigas = rs.getInt("vagas_totais");
			nome_curso = rs.getString("nome_curso");
			String descricao = rs.getString("descricao");
			double preco = rs.getDouble("preco");
			int vagas_totais = rs.getInt("vagas_totais");

			%>
			<form action="atualizar_curso.jsp" method="POST">
				<input type="hidden" name="id_curso" value="<%= id_curso %>">
				<input type="hidden" name="vagas_disponiveis" value="<%= vagas_disponiveis %>">
				<input type="hidden" name="vagas_totais_antigas" value="<%= vagas_totais_antigas %>">
				Titulo: <input type="text" name="nome_curso" value="<%= nome_curso %>"><br>
				Descriçao: <input type="text" name="descricao" value="<%= descricao %>"><br>
				Preco: <input type="number" name="preco" value="<%= preco %>"><br>
				Vagas Totais<input type="number" name="vagas_totais" value="<%= vagas_totais %>"><br>
				Vagas Disponiveis: <%= vagas_disponiveis %><br>
				<input type="submit" value="Atualizar curso">
			</form>

			

			<%
		}

		//Fazer query para achar os alunos que ainda nao estao inscritos
		String sql_alunos = "SELECT * FROM utilizadores WHERE perfil = 'aluno' AND id_utilizador NOT IN (SELECT id_utilizador FROM inscricoes WHERE id_curso = " + id_curso + ")";

		ps = conn.prepareStatement(sql_alunos);
		rs = ps.executeQuery();

		if (rs.next()) {
			%>
			<h2>Inscrever aluno</h2>
			<table border="1">
				<tr>
					<th>Id aluno</th>
					<th>Nome</th>
					<th>Ultimo nome</th>
					<th>Email</th>
					<th>Username</th>
					<th>Acao</th>
				</tr>
				<%
				do {
					int id_aluno = rs.getInt("id_utilizador");
					String nome = rs.getString("nome");
					String ultimo_nome = rs.getString("ultimo_nome");
					String email = rs.getString("e_mail");
					String username = rs.getString("user_name");
					%>
					<tr>
						<td><%= id_aluno %></td>
						<td><%= nome %></td>
						<td><%= ultimo_nome %></td>
						<td><%= email %></td>
						<td><%= username %></td>

						<td><a href='inscrever_curso.jsp?id_curso=<%= id_curso %>&id=<%= id_aluno %>'>Inscrever</a></td>
					</tr>
					
					<%
				} while (rs.next());
				%>
			</table>
			<%
		} else {
			out.println("<h4>Não há alunos para inscrever!</h4>");
		}

		String sqlInscricoes = "SELECT * FROM inscricoes WHERE id_curso = " + id_curso;
		ps = conn.prepareStatement(sqlInscricoes);
		rs = ps.executeQuery();
		

		if (rs.next()) {
			%>
			<h2> Nome do curso :<%= nome_curso %></h2>
			<h2> Inscrições: </h2>
			<table border="1">
				<tr>
					<th>Id inscricao</th>
					<th>Id aluno</th>
					<th>Nome aluno</th>
					<th>Data</th>
					<th>Acao</th>
					<th>Acao</th>
				</tr>
				<%
				do {
					int id_inscricao = rs.getInt("id_inscricao");
					int id_aluno = rs.getInt("id_utilizador");
					String data_inscricao = rs.getString("data_inscricao");

					String sql_nome_aluno = "SELECT nome FROM utilizadores WHERE id_utilizador = " + id_aluno;
					

					PreparedStatement psNome = conn.prepareStatement(sql_nome_aluno);
					ResultSet rsNome = psNome.executeQuery();

					
					if (rsNome.next()) {
						String nome_aluno = rsNome.getString("nome");
						%>
						<tr>
							<td><%= id_inscricao %></td>
							<td><%= id_aluno %></td>
							<td><%= nome_aluno %></td>
							<td><%= data_inscricao %></td>
							<td><a href='cancelar_inscricao.jsp?id_curso=<%= id_curso %>&id_utilizador=<%= id_aluno %>'>Cancelar</a></td>
							<td><a href='mudar_data.jsp?id_inscricao=<%= id_inscricao %> id_curso=<%= id_curso%>'>Mudar data</a></td>
						</tr>
						<%
					}
				} while (rs.next());
				%>
			</table>
			<%
		} else {
			out.println("<h4>Este curso ainda não tem incrições!<br></h4>");
		}

		ps.close();
		rs.close();
		conn.close();
	} else {
		out.println("Problemas com autenticação");
		response.setHeader("Refresh", "3;url=index.jsp");
	}
%>
</body>
</html>
