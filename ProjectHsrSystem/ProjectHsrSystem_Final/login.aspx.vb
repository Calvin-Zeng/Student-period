Public Class login
    Inherits System.Web.UI.Page
    Protected Sub Button1_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button1.Click

        Dim i As Integer
        Dim id As Integer
        Dim phone As Integer
        Dim sds As New SqlDataSource
        Dim sds1 As New SqlDataSource
        Dim sds2 As New SqlDataSource
        Dim sqlstr1 As String
        Dim sqlstr2 As String
        Dim phonenumber As String
        Dim dv1 As DataView
        Dim dv2 As DataView

        i = 0
        If (TextBox1.Text.Length <> 10) Then
            Label4.Visible = True
            Label4.Text = "請輸入標準格式的身分證字號"
            i = 0
        Else
            Label4.Visible = False
            Session("id") = TextBox1.Text.ToString
            id = 1
            i = i + id
        End If

        If (TextBox2.Text.Length <> 10) Then

            Label5.Visible = True
            Label5.Text = "請輸入標準格式的電話號碼"
            i = 0
        Else
            Label5.Visible = False
            Session("phone") = TextBox2.Text.ToString
            phone = 1
            i = i + phone

        End If

        If i = 2 Then
            sds1.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
            sqlstr1 = "select DISTINCT id from orderinfo where id='" & TextBox1.Text.ToString & "'"
            sds1.SelectCommand = sqlstr1
            dv1 = sds1.Select(New DataSourceSelectArguments())
            If dv1.Count = 0 Then
                Label4.Visible = True
                Label4.Text = "沒有此人資料"



            Else
                sds2.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
                sqlstr2 = "select DISTINCT phone from orderinfo where phone='" & TextBox2.Text.ToString & "'"
                sds2.SelectCommand = sqlstr2
                dv2 = sds2.Select(New DataSourceSelectArguments())
                If dv2.Count = 0 Then
                    Label4.Visible = False
                    Label5.Visible = True
                    Label5.Text = "密碼錯誤"

                Else
                    phonenumber = dv2.Table.Rows(0)(0).ToString()
                    If (TextBox2.Text = phonenumber) Then
                        Response.Redirect("bookingdetails.aspx")

                    End If
                End If

            End If
        End If
    End Sub
End Class