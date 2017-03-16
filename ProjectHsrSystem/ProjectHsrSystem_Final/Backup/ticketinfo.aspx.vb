Public Class ticketinfo
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load

    End Sub


    Protected Sub Button4_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button4.Click

        Dim i As Integer
        Dim id As Integer
        Dim phone As Integer
        Dim sds As New SqlDataSource
        Dim sqlstr1 As String

        i = 0
        If (TextBox1.Text.Length <> 10) Then
            Label11.Visible = True
            Label11.Text = "請輸入正確的身分證字號"
            i = 0
        Else
            Label11.Visible = False
            Session("id") = TextBox1.Text.ToString
            id = 1
            i = i + id
        End If


        If (TextBox2.Text.Length <> 10) Then
            Label12.Visible = True
            Label12.Text = "請輸入正確的電話號碼"
            i = 0

        Else
            Label12.Visible = False
            Session("phone") = TextBox2.Text.ToString
            phone = 1
            i = i + phone
        End If

        If Request.Cookies("CheckCode") Is Nothing Then
            TextBox2.Text = "無法取得Cookie，請檢察瀏覽器是否有封鎖Cookie!!"
        Else
            If String.Compare(TextBox3.Text.ToUpper, Request.Cookies("CheckCode").Value) <> 0 Then
                TextBox3.Text = "驗證碼錯誤!!"
            Else
                i = i + 1
            End If
        End If

        sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        If i = 3 Then
            If Session("return") = 1 Then
                Session("code") = TextBox3.Text.ToString

                sqlstr1 = "INSERT INTO orderinfo VALUES('" & Session("id") & "','" & Session("phone") & "','" & DateTime.Now.ToString("yyyy/MM/dd HH:mm:ss") & "','" & Session("startstation") & "','" & Session("endstation") & "','" & Session("number") & "',1,0,'" & Session("code") & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                sqlstr1 = "INSERT INTO ticketprinum VALUES('" & Session("code") & "',1,'" & Session("carcate") & "','" & Session("returnfcount") & "','" & Session("returnccount") & "','" & Session("returnocount") & "','" & Session("returnlcount") & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                sqlstr1 = "INSERT INTO orderinfo VALUES('" & Session("id") & "','" & Session("phone") & "','" & DateTime.Now.ToString("yyyy/MM/dd HH:mm:ss") & "','" & Session("returnstartstation") & "','" & Session("returnendstation") & "','" & Session("number") & "',1,0,'" & Session("code") & "_1" & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                sqlstr1 = "INSERT INTO ticketprinum VALUES('" & Session("code") & "_1" & "',1,'" & Session("carcate") & "','" & Session("returnfcount") & "','" & Session("returnccount") & "','" & Session("returnocount") & "','" & Session("returnlcount") & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                Response.Redirect("success.aspx")
            Else
                Session("code") = TextBox3.Text.ToString

                sqlstr1 = "INSERT INTO orderinfo VALUES('" & Session("id") & "','" & Session("phone") & "','" & DateTime.Now.ToString("yyyy/MM/dd HH:mm:ss") & "','" & Session("startstation") & "','" & Session("endstation") & "','" & Session("number") & "',1,0,'" & Session("code") & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                sqlstr1 = "INSERT INTO ticketprinum VALUES('" & Session("code") & "',1,'" & Session("carcate") & "','" & Session("fcount") & "','" & Session("ccount") & "','" & Session("ocount") & "','" & Session("lcount") & "')"
                sds.InsertCommand = sqlstr1
                sds.Insert()
                Response.Redirect("success.aspx")
            End If




        End If
    End Sub
End Class