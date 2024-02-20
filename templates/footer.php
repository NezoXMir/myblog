</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/myproject/www/">Главная страница</a></li>
        <li><a href="/myproject/www/about-me">Обо мне</a></li>
        <li><a href="/myproject/www/articles/add">Добавить статью</a></li>
        <li><a href="/myproject/www/articles/<?= $article->getId() ?>/edit" method="post">Редактировать свою статью</a></li>
    </ul>
</td>
</tr>
<tr>
    <td class="footer" colspan="2">Все права защищены &copy; Мой блог</td>
</tr>
</table>

</body>
</html>