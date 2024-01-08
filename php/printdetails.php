<?php
header('Content-Type: application/json');

if (is_numeric($_GET["id"])) {
	$id = intval($_GET["id"]);
} else {
	die();
}

$url = 'https://api.printables.com/graphql/';

//New query: 01/2024
$superQuery = 'query PrintProfile($id: ID!, $loadPurchase: Boolean!) {
    print(id: $id) {
      ...PrintDetailFragment
      price
      user {
        billingAccountType
        lowestTierPrice
        clubPrints {
          ...PrintListFragment
          __typename
        }
        __typename
      }
      purchaseDate @include(if: $loadPurchase)
      paidPrice @include(if: $loadPurchase)
      __typename
    }
  }
  
  fragment PrintDetailFragment on PrintType {
    id
    slug
    name
    authorship
    remixDescription
    premium
    price
    excludeCommercialUsage
    eduProject {
      id
      subject {
        id
        name
        slug
        __typename
      }
      language {
        id
        name
        __typename
      }
      free
      timeDifficulty
      audienceAge
      complexity
      equipment {
        id
        name
        __typename
      }
      suitablePrinters {
        id
        name
        __typename
      }
      organisation
      authors
      targetGroupFocus
      knowledgeAndSkills
      objectives
      equipmentDescription
      timeSchedule
      workflow
      approved
      datePublishRequested
      __typename
    }
    user {
      ...AvatarUserFragment
      isFollowedByMe
      canBeFollowed
      email
      publishedPrintsCount
      premiumPrintsCount
      designer
      stripeAccountActive
      membership {
        currentTier {
          id
          name
          benefits {
            id
            title
            benefitType
            description
            __typename
          }
          __typename
        }
        __typename
      }
      __typename
    }
    ratingAvg
    myRating
    ratingCount
    description
    category {
      id
      path {
        id
        name
        storeName
        description
        storeDescription
        __typename
      }
      __typename
    }
    modified
    firstPublish
    datePublished
    dateCreatedThingiverse
    nsfw
    summary
    shareCount
    likesCount
    makesCount
    liked
    printDuration
    numPieces
    weight
    nozzleDiameters
    usedMaterial
    layerHeights
    materials {
      id
      name
      __typename
    }
    dateFeatured
    downloadCount
    displayCount
    filesCount
    privateCollectionsCount
    publicCollectionsCount
    pdfFilePath
    commentCount
    userGcodeCount
    remixCount
    canBeRated
    printer {
      id
      name
      __typename
    }
    image {
      ...ImageSimpleFragment
      __typename
    }
    images {
      ...ImageSimpleFragment
      __typename
    }
    tags {
      name
      id
      __typename
    }
    thingiverseLink
    filesType
    license {
      id
      disallowRemixing
      __typename
    }
    remixParents {
      ...remixParentDetail
      __typename
    }
    gcodes {
      id
      name
      fileSize
      filePreviewPath
      __typename
    }
    stls {
      id
      name
      fileSize
      filePreviewPath
      __typename
    }
    slas {
      id
      name
      fileSize
      filePreviewPath
      __typename
    }
    ...LatestCompetitionResult
    competitions {
      id
      name
      slug
      description
      isOpen
      __typename
    }
    competitionResults {
      placement
      competition {
        id
        name
        slug
        printsCount
        openFrom
        openTo
        __typename
      }
      __typename
    }
    __typename
  }
  
  fragment AvatarUserFragment on UserType {
    id
    publicUsername
    avatarFilePath
    handle
    company
    verified
    badgesProfileLevel {
      profileLevel
      __typename
    }
    __typename
  }
  
  fragment ImageSimpleFragment on PrintImageType {
    id
    filePath
    rotation
    __typename
  }
  
  fragment remixParentDetail on PrintRemixType {
    id
    parentPrintId
    parentPrintName
    parentPrintAuthor {
      id
      slug
      publicUsername
      company
      verified
      handle
      __typename
    }
    parentPrint {
      id
      name
      slug
      datePublished
      image {
        ...ImageSimpleFragment
        __typename
      }
      premium
      authorship
      license {
        id
        name
        disallowRemixing
        __typename
      }
      eduProject {
        id
        __typename
      }
      __typename
    }
    url
    urlAuthor
    urlImage
    urlTitle
    urlLicense {
      id
      name
      disallowRemixing
      __typename
    }
    urlLicenseText
    __typename
  }
  
  fragment LatestCompetitionResult on PrintType {
    latestCompetitionResult {
      placement
      competitionId
      __typename
    }
    __typename
  }
  
  fragment PrintListFragment on PrintType {
    id
    name
    slug
    ratingAvg
    likesCount
    liked
    datePublished
    dateFeatured
    firstPublish
    downloadCount
    category {
      id
      path {
        id
        name
        __typename
      }
      __typename
    }
    modified
    image {
      ...ImageSimpleFragment
      __typename
    }
    nsfw
    premium
    price
    user {
      ...AvatarUserFragment
      __typename
    }
    ...LatestCompetitionResult
    __typename
  }';

$contentJson = json_encode(array('operationName' => 'PrintProfile', 'query' => $superQuery, 'variables' => array('id' => $id)));

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\nAccept-Language: de,en-US\r\n",
        'method'  => 'POST',
        'content' => $contentJson
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
	json_encode(array('data' => null));
} else {
	echo $result;
}

?>
