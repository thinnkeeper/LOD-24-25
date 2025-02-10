<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aluno</title>
	<style>
        ul {
            margin-bottom: 20px; /* Aumenta o espaço entre os itens da lista */
        }
        .form-container {
            margin-bottom: 30px; /* Aumenta o espaço entre os formulários */
        }
        form {
            display: inline-block;
            margin-bottom: 20px; /* Aumenta o espaço entre os formulários */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: c;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<%
	String perfil = (String) session.getAttribute("perfil");
	String userName = (String) session.getAttribute("user_name");
	int idAluno = (int) session.getAttribute("id");

	if (userName != null && perfil.equals("aluno")) {
%>
	<a href="logout.jsp">Logout</a>
	<h1>Bem-vindo <%= userName %></h1><h4> Você está na página do aluno</h4>
	<a href="editar_perfil.jsp">Editar Perfil<br></a><br>

	<%
		//Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;

		

		String sql = "SELECT * FROM cursos WHERE id_curso IN (SELECT id_curso FROM inscricoes WHERE id_utilizador = " + idAluno + ")";
		ps = conn.prepareStatement(sql);
		rs = ps.executeQuery(sql);

		if (rs.next()) {
	%>
			<h2>Cursos em que está inscrito:</h2>
			<table border="1">
				<tr>
					<th>Id_curso</th>
					<th>Nome docente</th>
					<th>Título do curso</th>
					<th>Descrição</th>
					<th>Preço</th>
					<th>Número de vagas Restantes</th>
					<th>Ação</th>
				</tr>
	<%
				do {
					int idCurso = rs.getInt("id_curso");

						String sql3 = "SELECT nome FROM utilizadores WHERE id_utilizador = " + rs.getInt("id_utilizador");
					PreparedStatement ps3 = conn.prepareStatement(sql3);
					ResultSet rs3 = ps3.executeQuery(sql3);
					rs3.next();
					String  nomeDocente = rs3.getString("nome");
							

					String nomeCurso = rs.getString("nome_curso");
					String descricao = rs.getString("descricao");
					double preco = rs.getDouble("preco");
					int vagasDisponiveis = rs.getInt("vagas_disponiveis");
	%>
				<tr>
					<td><%= idCurso %></td>
					<td><%= nomeDocente %></td>
					<td><%= nomeCurso %></td>
					<td><%= descricao %></td>
					<td>€<%= preco %></td>
					<td><%= vagasDisponiveis %></td>
					<td><a href="cancelar_inscricao.jsp?id_curso=<%= idCurso %>&id_utilizador=<%= idAluno %>">Cancelar</a></td>
				</tr>
			</table>
	<%
				} while (rs.next());

			} else {
	%>
			<h4>Ainda não está inscrito em nenhum curso! Não perca a oportunidade !</h4>
	<%
			}

			sql = "SELECT * FROM cursos WHERE id_curso NOT IN (SELECT id_curso FROM inscricoes WHERE id_utilizador = " + idAluno + ")";
			ps = conn.prepareStatement(sql);
			rs = ps.executeQuery(sql);

			if (rs.next()) {
	%>
			<h2>Cursos em que pode se inscrever:</h2>
			<table border="1">
				<tr>
					<th>Id_curso</th>
					<th>Nome docente</th>
					<th>Título do curso</th>
					<th>Descrição</th>
					<th>Preço</th>
					<th>Número de vagas Restantes</th>
					<th>Ação</th>
				</tr>
	<%
				do {
					int idCurso = rs.getInt("id_curso");

					String sql2 = "SELECT nome FROM utilizadores WHERE id_utilizador = " + rs.getInt("id_utilizador");
					PreparedStatement ps2 = conn.prepareStatement(sql2);
					ResultSet rs2 = ps2.executeQuery(sql2);
					rs2.next();
					String  nomeDocente = rs2.getString("nome");

					String nomeCurso = rs.getString("nome_curso");
					String descricao = rs.getString("descricao");
					double preco = rs.getDouble("preco");
					int vagasDisponiveis = rs.getInt("vagas_disponiveis");
	%>
				<tr>
					<td><%= idCurso %></td>
					<td><%= nomeDocente %></td>
					<td><%= nomeCurso %></td>
					<td><%= descricao %></td>
					<td><%= preco %>€</td>
					<td><%= vagasDisponiveis %></td>
					<td><a href="inscrever_curso.jsp?id_curso=<%= idCurso %>">Inscrever-se</a></td>
				</tr>
	<%
				} while (rs.next());
			rs.close();
			ps.close();
			conn.close();
				
			}
	} else {
		out.println("Acesso negado");
		response.setHeader("Refresh", "3; URL=index.jsp");
	}

	
	

		
%>

</body>
</html>