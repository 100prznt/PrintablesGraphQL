var id = 46705;

$.ajax({
	method: "POST",
	url: "https://www.prusaprinters.org/graphql/",
	contentType: "application/json",
	data: JSON.stringify({
		operationName:"PrintProfile",
		query: `query PrintProfile($id: ID!) {
				print(id: $id) {
					id
					slug
					name
					user {
						id
						publicUsername
						avatarFilePath
						slug
						badgesProfileLevel {
							profileLevel
						}
						printsCount
					}
					ratingAvg
					ratingCount
					description
					modified
					firstPublish
					datePublished
					summary
					shareCount
					likesCount
					makesCount
					downloadCount
					displayCount
					filesCount
					collectionsCount
					commentCount
					images {
						filePath
					}
					thingiverseLink
					license {
						id
						disallowRemixing
					}
				}
			}`,
		variables: {
			"id": id
		}
	})
}).done(function(response) {
	console.log("DATA:");
	console.log(data);
});