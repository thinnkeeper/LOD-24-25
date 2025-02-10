<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    PreparedStatement ps=null;
    ResultSet rs=null;
    
    // verificar se o utilizador está autenticado
    if (session.getAttribute("perfil") == null) {
        out.println("Não tem permissão para aceder a esta página.");
        response.setHeader("Refresh", "3; URL=index.jsp");
    } else {
        
        String id_utilizador = request.getParameter("id_utilizador");
        String nome = request.getParameter("nome");
        String ultimo_nome = request.getParameter("ultimo_nome");
        String new_user_name = request.getParameter("user_name");
        String old_user_name = (String) session.getAttribute("user_name");
        String password = request.getParameter("password");

        if (nome.isEmpty() || ultimo_nome.isEmpty() || new_user_name.isEmpty() || password.isEmpty()) {
            out.println("Não pode haver valores vazios");
            response.setHeader("Refresh", "3; URL=editar_perfil.jsp");
        } else {
            String tipo_perfil = (String) session.getAttribute("perfil");

            // Update user profile
            String sql = "UPDATE utilizadores SET nome = ?, ultimo_nome = ?, user_name = ?, password = MD5(?) WHERE id_utilizador = ?";
            ps = conn.prepareStatement(sql);
            ps.setString(1, nome);
            ps.setString(2, ultimo_nome);
            ps.setString(3, new_user_name);
            ps.setString(4, password);
            ps.setString(5, id_utilizador);
            int rowsAffected = ps.executeUpdate();

            if (rowsAffected > 0) {
                out.println("Utilizador com id=" + id_utilizador + " atualizado com sucesso!<br>");
                out.println("Antigo user_name=" + old_user_name + "<br>");
                out.println("Novo user_name=" + new_user_name + "<br>");
                session.setAttribute("user_name", new_user_name);

                String home_page_perfil = null;
                switch (tipo_perfil) {
                    case "aluno":
                        home_page_perfil = "menu_aluno.jsp";
                        break;
                    case "docente":
                        home_page_perfil = "menu_docente.jsp";
                        break;
                    case "admin":
                        home_page_perfil = "menu_admin.jsp";
                        break;
                }

                out.println("<br><a href='" + home_page_perfil + "'>Home Page</a>");
            }
        }

        //rs.close();
        ps.close(); 
        conn.close();

    }
    
%>