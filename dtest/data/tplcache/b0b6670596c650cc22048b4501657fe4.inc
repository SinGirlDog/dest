<li>
          [field:array runphp='yes']
          @me = (empty(@me['litpic']) ? "<img src='[field:global.cfg_basehost/]/templets/mem/images/tuk1.jpg'>" : "<img src='{@me['litpic']}'/>"); 
          [/field:array]
          <h3><span>最新</span><a target="_blank" href="[field:arcurl/]">[field:title function='TitleReplace("MEM","@me")'/]</a></h3>
          <p>[field:infos/]...</p>
        </li>