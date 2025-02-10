<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    if (session.getAttribute("perfil") == null ){
        response.setHeader("Refresh", "2; URL=index.jsp");
    } else {
        String perfil = (String) session.getAttribute("perfil");

        PreparedStatement ps = null;
        ResultSet rs = null;

        
        String id_aluno =  Integer.toString((Integer)session.getAttribute("id"));
        String id_curso = (String)request.getParameter("id_curso");

        //query que mostra o numero de vagas disponiveis naquele curso
        String vagas = "SELECT vagas_disponiveis FROM cursos WHERE id_curso = " + id_curso;

        ps = conn.prepareStatement(vagas);
        rs = ps.executeQuery();

        if (rs.next()) {
            int vagas_restantes = rs.getInt("vagas_disponiveis");

            if (vagas_restantes > 0) {
                //se há vagas insere na tabela inscricoes os dados do aluno e do curso
                String sql = "INSERT INTO inscricoes (id_utilizador, id_curso) VALUES (?, ?)";
                PreparedStatement pps = conn.prepareStatement(sql);
                pps.setString(1, id_aluno);
                pps.setString(2, id_curso);
                pps.executeUpdate();
                pps.close();

                out.println("Inscrição realizada com sucesso!<br>");
                if (perfil.equals("aluno")) {
                    response.setHeader("Refresh", "2; URL=menu_aluno.jsp");
                } else if (perfil.equals("admin")){
                    response.setHeader("Refresh", "2; URL=menu_admin.jsp");
                } else {
                    response.setHeader("Refresh", "2; URL=menu_docente.jsp");
                }

                vagas_restantes--;
                String updateSql = "UPDATE cursos SET vagas_disponiveis = ? WHERE id_curso = ?";
                PreparedStatement updateps = conn.prepareStatement(updateSql);
                updateps.setInt(1, vagas_restantes);
                updateps.setString(2, id_curso);
                updateps.executeUpdate();
                updateps.close();
            } else {
                out.println("Não é possível se inscrever neste curso");
                response.setHeader("Refresh", "5; URL=menu_aluno.jsp");
            }
        }
        rs.close();
        ps.close();
        conn.close();

    
    }

    
    
%>