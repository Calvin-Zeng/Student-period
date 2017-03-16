Imports System.Drawing

Public Class CheckImageCode
    Inherits System.Web.UI.Page

    Private Function GenerateCheckCode() As String
        Dim number As Integer
        Dim code As Char
        Dim checkCode As String = String.Empty
        Dim random As System.Random = New Random()
        '要製造出幾個驗證碼
        For i As Integer = 0 To 3
            'number = random.[Next]()
            number = random.Next
            '亂數決定哪一個是數字或字母
            If number Mod 2 = 0 Then
                code = CChar(ChrW(Asc("0") + (number Mod 10)))
            Else
                code = CChar(ChrW(Asc("A") + (number Mod 26)))
            End If
            checkCode += code.ToString()
        Next
        '寫入Cook
        Response.Cookies.Add(New HttpCookie("CheckCode", checkCode))
        Return checkCode
    End Function

    Private Sub CreateCheckCodeImage(ByVal checkCode As String)
        If checkCode Is Nothing OrElse checkCode.Trim() = [String].Empty Then
            Return
        End If

        'System.Drawing.Bitmap image = new System.Drawing.Bitmap((int)Math.Ceiling((checkCode.Length * 12.5)), 22);
        'System.Drawing.Bitmap image = new System.Drawing.Bitmap((int)Math.Ceiling((checkCode.Length * 20)), 40);
        Dim image As New System.Drawing.Bitmap(100, 30)

        Dim g As Graphics = Graphics.FromImage(image)

        Try
            '生成隨機生成器
            Dim random As New Random()

            '清空圖片背景色
            g.Clear(Color.White)

            '畫圖片的背景噪音線
            For i As Integer = 0 To 24
                Dim x1 As Integer = random.[Next](image.Width)
                Dim x2 As Integer = random.[Next](image.Width)
                Dim y1 As Integer = random.[Next](image.Height)
                Dim y2 As Integer = random.[Next](image.Height)

                g.DrawLine(New Pen(Color.Silver), x1, y1, x2, y2)
            Next

            Dim font As Font = New System.Drawing.Font("Arial", 22, (System.Drawing.FontStyle.Bold Or System.Drawing.FontStyle.Italic))
            Dim brush As New System.Drawing.Drawing2D.LinearGradientBrush(New Rectangle(0, 0, image.Width, image.Height), Color.Blue, Color.DarkRed, 1.2F, True)
            'g.DrawString(checkCode, font, brush, 2, 2);
            g.DrawString(checkCode, font, brush, 2, 2)

            '畫圖片的前景噪音點
            For i As Integer = 0 To 499
                Dim x As Integer = random.[Next](image.Width)
                Dim y As Integer = random.[Next](image.Height)

                image.SetPixel(x, y, Color.FromArgb(random.Next))
            Next

            '畫圖片的邊框線
            g.DrawRectangle(New Pen(Color.Silver), 0, 0, image.Width - 1, image.Height - 1)

            Dim ms As New System.IO.MemoryStream()
            image.Save(ms, System.Drawing.Imaging.ImageFormat.Gif)
            Response.ClearContent()
            Response.ContentType = "image/Gif"
            Response.BinaryWrite(ms.ToArray())
        Finally
            g.Dispose()
            image.Dispose()
        End Try
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        CreateCheckCodeImage(GenerateCheckCode())
    End Sub
End Class