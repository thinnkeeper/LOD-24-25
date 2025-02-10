<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    PreparedStatement ps = null;
    //ResultSet rs = null;

    if (session.getAttribute("perfil") != null && session.getAttribute("perfil").equals("admin")|| session.getAttribute("perfil").equals("docente")) {

        String id_curso = request.getParameter("id_curso");
        String nome_curso = request.getParameter("nome_curso");
        String descricao = request.getParameter("descricao");
        String preco = request.getParameter("preco");
        String vagas_totais = request.getParameter("vagas_totais");
        String vagas_antigas = request.getParameter("vagas_totais_antigas");
        String vagas_disponiveis = request.getParameter("vagas_disponiveis");

        int novas_vagas = Integer.parseInt(vagas_disponiveis) + (Integer.parseInt(vagas_totais) - Integer.parseInt(vagas_antigas));

        if (nome_curso.isEmpty() || descricao.isEmpty() || preco.isEmpty() || vagas_totais.isEmpty() || Integer.parseInt(vagas_totais) < (Integer.parseInt(vagas_antigas) - Integer.parseInt(vagas_disponiveis))) {
            out.println("Não pode haver valores vazios ou menos vagas totais que o número de alunos inscritos neste curso.");
            response.setHeader("Refresh", "3; URL=gerenciar_curso.jsp");
        } else {
            String tipo_perfil = (String) session.getAttribute("perfil");

            String sql = "UPDATE cursos SET nome_curso = ?, descricao = ?, preco = ?, vagas_totais = ?, vagas_disponiveis = ? WHERE id_curso = ?";
            ps = conn.prepareStatement(sql);
            ps.setString(1, nome_curso);
            ps.setString(2, descricao);
            ps.setString(3, preco);
            ps.setString(4, vagas_totais);
            ps.setString(5, String.valueOf(novas_vagas));
            ps.setString(6, id_curso);

            
            int rowsAffected = ps.executeUpdate();

            if (rowsAffected > 0) {
                out.println("Curso " + nome_curso + " atualizado com sucesso!<br>");

                String home_page_perfil = null;
                switch (tipo_perfil) {
                    case "docente":
                        home_page_perfil = "menu_docente.jsp";
                        break;
                    case "admin":
                        home_page_perfil = "menu_admin.jsp";
                        break;
                }

                response.setHeader("Refresh", "2; URL=" + home_page_perfil);
                ps.close();
                conn.close();
            }
        }
    } else {
        out.println("Não tem permissão para aceder a esta página.");

        if (session.getAttribute("perfil").equals("aluno")) {
            response.setHeader("Refresh", "3; URL=menu_aluno.jsp");
        } else {
            response.setHeader("Refresh", "3; URL=index.jsp");
        }

        
    }

    

    
    

%>