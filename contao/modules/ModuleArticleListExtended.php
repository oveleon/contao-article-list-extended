<?php

namespace Oveleon\ContaoArticleListExtended;

use Contao\ArticleModel;
use Contao\Environment;
use Contao\ModuleArticleList;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\Routing\Exception\ExceptionInterface;

class ModuleArticleListExtended extends ModuleArticleList
{
	protected function compile()
	{
		/** @var PageModel $objPage */
		global $objPage;

		if (!$this->inColumn)
		{
			$this->inColumn = 'main';
		}

		$id = $objPage->id;
		$objTarget = null;

		$this->Template->request = Environment::get('request');

		// Show the articles of a different page
		if ($this->defineRoot && ($objTarget = $this->objModel->getRelated('rootPage')) instanceof PageModel)
		{
			$id = $objTarget->id;

			/** @var PageModel $objTarget */
			$this->Template->request = $objTarget->getFrontendUrl();
		}

		// Get published articles
		$objArticles = ArticleModel::findPublishedByPidAndColumn($id, $this->inColumn);

		if ($objArticles === null)
		{
			$this->Template->articles = array();

			return;
		}

		$intCount = 0;
		$articles = array();
		$objHelper = $objTarget ?: $objPage; // PHP 5.6 compatibility (see #939)

		while ($objArticles->next())
		{
			// Skip first article
			if (++$intCount <= (int) $this->skipFirst || $objArticles->hideInArticleList)
			{
				continue;
			}

			try
			{
				$href = $objHelper->getFrontendUrl('/articles/' . ($objArticles->alias ?: $objArticles->id));
			}
			catch (ExceptionInterface $exception)
			{
				continue;
			}

			$cssID = StringUtil::deserialize($objArticles->cssID, true);

			$articles[] = array
			(
				'link' => $objArticles->title,
				'title' => StringUtil::specialchars($objArticles->title),
				'id' => ($cssID[0] ?? null) ?: 'article-' . $objArticles->id,
				'articleId' => $objArticles->id,
				'href' => $href
			);
		}

		$this->Template->articles = $articles;
	}
}
