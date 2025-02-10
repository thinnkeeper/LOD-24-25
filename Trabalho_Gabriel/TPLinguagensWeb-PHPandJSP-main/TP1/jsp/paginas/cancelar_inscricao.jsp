<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    // Verificar se o utilizador esta logado
    if (session.getAttribute("perfil") == null) {
        response.sendRedirect("index.jsp");
    } else {

        
        PreparedStatement ps = null;
        ResultSet rs = null;

        if (session.getAttribute("perfil") != null) {
            

            String id_aluno = request.getParameter("id_utilizador");
            String id_curso = request.getParameter("id_curso");

            String sql = "DELETE FROM inscricoes WHERE id_curso = " + id_curso + " AND id_utilizador = " + id_aluno;
            ps = conn.prepareStatement(sql);
            int rowsAffected = ps.executeUpdate(sql);

            if (rowsAffected > 0) {
                out.println("Cancelamento realizado com sucesso!<br>");

                String perfil = (String) session.getAttribute("perfil");
                switch (perfil){
                    case "aluno":
                        out.println("<a href='menu_aluno.jsp'>Home Page</a>");
                        response.setHeader("Refresh", "3; URL=menu_aluno.jsp");
                        break;
                    case "docente":
                        out.println("<a href='menu_docente.jsp'>Home Page</a>");
                        response.setHeader("Refresh", "3; URL=menu_docente.jsp");
                        break;
                    case "admin":
                        out.println("<a href='menu_admin.jsp'>Home Page</a>");
                        response.setHeader("Refresh", "3; URL=menu_admin.jsp");
                        break;
                }


                String vagasQuery = "SELECT vagas_disponiveis FROM cursos WHERE id_curso = " + id_curso;
                PreparedStatement ps2 = conn.prepareStatement(vagasQuery);
                rs = ps2.executeQuery();

                int vagas_restantes = 0;
                if (rs.next()) {
                    vagas_restantes = rs.getInt("vagas_disponiveis");
                }
                vagas_restantes += 1;

                String updateVagasQuery = "UPDATE cursos SET vagas_disponiveis = " + vagas_restantes + " WHERE id_curso = " + id_curso;
                PreparedStatement ps3 = conn.prepareStatement(updateVagasQuery);
                ps3.executeUpdate(updateVagasQuery);
            } else {
                out.println("Houve um problema com a inserção na base de dados");
            }
        } 
        
        conn.close();
        
    }
%>