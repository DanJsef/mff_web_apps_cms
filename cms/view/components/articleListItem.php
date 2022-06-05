<?php

function artiticleListItem($id, $name)
{
    $name = htmlspecialchars($name);
    return "
						<div class='articleListItem space-between' data-id='$id'>
							<span>$name</span>
							<div>
								<a class='button' href='article/$id'>Show</a>
								<a class='button' href='article-edit/$id'>Edit</a>
								<button class='button' onclick='remove($id)'>Delete</button>
							</div>
						</div>
					 ";
}
